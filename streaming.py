"""
OANDA open api - get pairs and write to named pipe.
named pipe is read by worker process in PHP.

Set OANDA_TOKEN in .env file
Set OANDA_ACCOUNT in .env file

To execute, run the following command:
python streaming.py [options]
To show heartbeat, replace [options] by -b or --displayHeartBeat
"""

import requests
import json
import dotenv
import os

from optparse import OptionParser

def connect_to_stream():

    """
    Environment                 Description
    fxTrade (Live)              The live (real money) environment
    fxTrade Practice (Demo)     The demo (simulated money) environment
    """

    dotenv.load()

    domainDict = {
        'live' : 'stream-fxtrade.oanda.com',
        'demo' : 'stream-fxpractice.oanda.com'
    }

    # Replace the following variables with your personal values
    environment = "demo" # Replace this 'live' if you wish to connect to the live environment
    domain = domainDict[environment]
    access_token = os.environ.get('OANDA_TOKEN')
    account_id = os.environ.get('OANDA_ACCOUNT')
    instruments = 'USD_JPY,EUR_USD,AUD_USD,EUR_GBP,USD_CAD,USD_CHF,USD_MXN,USD_TRY,USD_CNH,NZD_USD'

    try:
        s = requests.Session()
        url = "https://" + domain + "/v3/accounts/" + account_id + "/pricing/stream"
        headers = {'Authorization' : 'Bearer ' + access_token,
                   # 'X-Accept-Datetime-Format' : 'unix'
                  }
        params = {'instruments' : instruments}
        req = requests.Request('GET', url, headers = headers, params = params)
        pre = req.prepare()
        resp = s.send(pre, stream = True, verify = True)
        return resp
    except Exception as e:
        s.close()
        print("Caught exception when connecting to stream\n" + str(e))

def demo(displayHeartbeat):
    response = connect_to_stream()
    if response.status_code != 200:
        print(response.text)
        return
    for line in response.iter_lines(1):
        if line:
            try:
                line = line.decode('utf-8')
                msg = json.loads(line)
            except Exception as e:
                print("Caught exception when converting message into json\n" + str(e))
                return

            if "prices" in msg or displayHeartbeat:
                fifo=open('quotes','a')
                fifo.write(line + "\n")
                #print(line)

def main():
    usage = "usage: %prog [options]"
    parser = OptionParser(usage)
    parser.add_option("-b", "--displayHeartBeat", dest = "verbose", action = "store_true",
                        help = "Display HeartBeat in streaming data")
    displayHeartbeat = False

    (options, args) = parser.parse_args()
    if len(args) > 1:
        parser.error("incorrect number of arguments")
    if options.verbose:
        displayHeartbeat = True
    demo(displayHeartbeat)


if __name__ == "__main__":
    main()

# bowhead
Console PHP trading bot boilerplate/framework 
-
Written by Joel De Gan, 2017


Bowhead (a type of whale) is the codename for a boilerplate within Laravel for building 
Cryptocurrency and Forex automated systems.

It utilizes all the TALib functions implemented in the Trader extenstion for PHP
and creates some of it's own indicators which are composites of those from TALib.

#### Focus of the project.
The primary focus is to have an easy to use boilerplate/framework that you can 
rapidly create a fully functional trading system on various strategies on 
BTC funded trading platforms that typically do not require that you are "verified"
this way you can trade with funds without funneling them through your bank and
having to deal with some potential tax issues (depending on the country you live in)

#### Companion article
This project has a companion article which walks you through how to set it up and walks you through 
setting up your first strategy and running it on [Whaleclub](https://whaleclub.co/join/tn6uE) 
and on [1Broker](https://1broker.com/?r=21434), which you will need accounts on both.
 
[You can find the companion article HERE](http://goo.gl/0b8JZD)

I highly suggest you read through it and follow along to get it up and running.

#### basica setup
You will need 
* PHP7.1
* Redis
* MySql 
* the PHP Pecl Trader extension, 

for Python
you will need the dotenv package. 
````
pip install python-env
````

#### Notes
This project was initially done in the Laravel-Lumen (lightweight) framework 
however the move to a fully open sourced boilerplate/framework I felt that having the 
full ability of Laravel could be important, particularly Jobs and other parts which
utilize queues could be invaluable.

Bowhead was written and tested on a Mac and I have it running in the cloud on an
Ubuntu linux server in AWS making real money trades every day on the Crypto
markets, on Forex pairs and on binary options.

One limitation that may mess up this running on Windows is the usage of a
named pipe for passing data between Python and PHP in real time, there are
ways around this, such as using Redis, or piping the output to a parser. 

I am open to suggestions for how to get it to work on Windows
 
#### A note about editors. 
> I would like to additionally say that when you are working with Laravel, it
 it is almost mandatory to use an editor like PHPStorm, you 'can' use something like
 Atom but it would be like trying to use notepad to work on a dotNet project,
 you can technically 'do it' but it will be frustrating and you will not have
 a good time.  I cannot recommend PHPStorm more highly. They have a free trial
 and with updates it extends the trial period, even still, if you choose to purchase
 it, it's not expensive.
 
#### additional libraries
 I have added a couple utility libs that I like to use with this.
 
 - Console class, this is for colorizing, doing progress bars and doing text tables in console which look like the following.
````
 ╔═══════════════════════════════════════════════╗
 ║ BTC    │ 1QBhVZETNEyuJRgX6e8cJWBdCkq75bQ5o1   ║
 ║ DOGE   │ DEHjsyvHgDAQvAfwgPoHWjC3AVqAAp22eL   ║
 ╚════════╧══════════════════════════════════════╝
````

DONE:
1) Write my own Coinbase, Whaleclub, 1Broker wrappers.
2) Create Indicators wrapper for TALib.
3) Create Candles wrapper for TALib
4) Collect console functions into one Console class.
5) Streaming data from Oanda
6) Streaming data from Bitfinex

TODO:
1) Standardize the calls to brokerages so the method names are the same across all of them.
2) Generalized object wrapper for brokerages.
3) Write my own Oanda, Bitfinex and Poloniex API wrappers.
4) reporting, logging and backtesting tools.


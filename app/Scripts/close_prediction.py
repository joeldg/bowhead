#!/usr/local/bin/python

import pandas as pd
import redis
import sys
import numpy as np
from sklearn.linear_model import LinearRegression

r = redis.StrictRedis(host='localhost', port=6379, db=0)
book = r.get('laravel:tempbook')
if sys.version_info[0] < 3:
    from StringIO import StringIO
else:
    from io import StringIO
TDATA=StringIO(book)

df = pd.read_csv(TDATA)
to_forecast = df.close.values
dates = df.id.values

# mean absolute percentage error
def mape(ypred, ytrue):
    """ returns the mean absolute percentage error """
    idx = ytrue != 0.0
    return 100*np.mean(np.abs(ypred[idx]-ytrue[idx])/ytrue[idx])

def organize_data(to_forecast, window, horizon):
    """
     Input:
      to_forecast, univariate time series organized as numpy array
      window, number of items to use in the forecast window
      horizon, horizon of the forecast
     Output:
      X, a matrix where each row contains a forecast window
      y, the target values for each row of X
    """
    shape = to_forecast.shape[:-1] + (to_forecast.shape[-1] - window + 1, window)
    strides = to_forecast.strides + (to_forecast.strides[-1],)
    X = np.lib.stride_tricks.as_strided(to_forecast, shape=shape, strides=strides)
    y = np.array([X[i+horizon][-1] for i in range(len(X)-horizon)])
    return X[:-horizon], y

k = 4   # number of previous observations to use
h = 1   # forecast horizon
X,y = organize_data(to_forecast, k, h)

m = 10 # number of samples to take in account
regressor = LinearRegression(normalize=True)
regressor.fit(X[:m], y[:m])

#print regressor.coef_
#print 'The error is:%0.2f%%' % mape(regressor.predict(X[m:]),y[m:])
#print y[m:]
#print regressor.predict(X[m:])
#print str(regressor.predict(X[m:])).strip('[]')
#print ', '.join(map(str, y[m:]))


# print out and pop off the last number for the prediction.
print ','.join(map(str, regressor.predict(X[m:])))

"""
http://glowingpython.blogspot.com/2015/01/forecasting-beer-consumption-with.html

figure(figsize=(8,6))
plot(y, label='True demand', color='#377EB8', linewidth=2)
plot(regressor.predict(X),
     '--', color='#EB3737', linewidth=3, label='Prediction')
plot(y[:m], label='Train data', color='#3700B8', linewidth=2)
xticks(arange(len(dates))[1::4],dates[1::4], rotation=45)
legend(loc='upper right')
ylabel('beer consumed (millions of litres)')
show()
"""


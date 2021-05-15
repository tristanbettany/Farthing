# Farthing

This is the 3rd iteration of my personal finance application. This time it comes with a hip & trendy name popular amongst 
the ~~laravel~~ web community. 

The software is designed to store your bank accounts and transactions in a nice user friendly interface. Key
features are, that you can create coloured tags which automatically apply to transactions upon import, and you can create
templates which will generate and predict transactions into the future based on pre-defined patterns. It also includes 
github login for easy authentication.

The above features allow you to easily control budgeting your life style way into the future, and all in a super nice 
user interface. No more using excel spreadsheets or squinting at silly on trend mobile phone apps!

## Setup

I recommend self hosting this instead of setting it up remotley due to security over your bank details. Wack it on
a server at home or a Raspberry PI and then expose the ports to your local network and access the application from whatever 
devices need to use it.

To setup the application on your server do the following things:

- start docker
- run `./app.bat build`
- open a connection to the database containers mysql and create a database
- copy the `.env.example` file to `.env`
- change your database connection details accordingly
- setup an oauth2 application in your github profile with a callback url of `https://farthing.test/github/login` 
  and put the clientid and secret in the `.env` file
- run `./app.bat laravel-key`
- run `./app.bat install`
- run `./app.bat migrate-up`

> NOTE: for linux/mac users you will need to do the same things but all batch file commands replace with the
> docker commands they actually run

## Usage

- Make sure to import the `ssl.cer` file in this directory to your browser which will allow `farthing.test` SSL to work
- Make sure to add `farthing.test` to your hosts file pointing to your local machine
- Now you should be able to visit and login with your github account at `https://farthing.test`

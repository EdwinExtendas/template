# Api
This api is using [ApiPlatform](https://api-platform.com/) 2.4

#TODO
- add command for generating organization
- on organization creation; create admin user & schedule get point of services command
- get points of service command crashes first time?

## Project setup
#### Requirements
- Apache
- Php 7.1
- Php-fpm
- Mysql 5.7.* # TODO: should be mariaDB
- Composer
- [Mercure](https://github.com/dunglas/mercure/releases)
- [Apcu Cache](https://symfony.com/doc/current/components/cache/adapters/apcu_adapter.html) # needs to be installed as extension in your php.ini

##### Coding standard
We use php-cs-fixer and the [symfony standard](https://symfony.com/doc/master/contributing/code/standards.html).

config is found in .php_cs.dist

#### Install
```
composer install
```

[Generate JWT private & public keys](https://github.com/lexik/LexikJWTAuthenticationBundle/blob/master/Resources/doc/index.md#installation) 

```
cd /path/to/your/project
mkdir config/jwt
openssl genrsa -out config/jwt/private.pem -aes256 4096
openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
```

execute:
```
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate -n
```

For dev execute:
```
php bin/console doctrine:fixtures:load -n
```

## Mercure
### Setup mercure
- go to mercure on github [here](https://github.com/dunglas/mercure/releases)
- Download docker image or the executable mercure at Assets [here](https://github.com/dunglas/mercure/releases)
- Save those files somewhere on your pc and create an .env file in the same directory (or take the .env.mercure.dist from the api)
- put the following in the .env file
```
JWT_KEY='your-256-bit-secret-for-jwt-token' 
ADDR=':3000' 
DEMO=1 
ALLOW_ANONYMOUS=1 
PUBLISH_ALLOWED_ORIGINS='http://localhost:3000'
CORS_ALLOWED_ORIGINS=*
```
- start mercure with ./path/to/folder/mercure

### Supervisor
```
; Mercure is symfony Server-Sent-Event Hub/server
[program:mercure]
command=/path/to/folder/mercure
process_name=%(program_name)s_%(process_num)s
numprocs=1
; environment=JWT_KEY="your-256-bit-secret"
directory=/path/to/folder
autostart=true
autorestart=true
startsecs=5
startretries=10
user=spin
redirect_stderr=false
stdout_capture_maxbytes=1MB
stderr_capture_maxbytes=1MB
stdout_logfile=/path/to/folder/logs/mercure.out.log
stderr_logfile=/path/to/folder/logs/mercure.error.log
```

### Apache config
```apacheconfig
<VirtualHost *:80>
    ServerName hub.spinpay.spinpos.com
    ServerAlias www.hub.spinpay.spinpos.com

    ProxyRequests off

    <Proxy *>
            Order deny,allow
            Allow from all
    </Proxy>

    <Location />
            ProxyPass http://localhost:3000/
            ProxyPassReverse http://localhost:3000/
    </Location>
</VirtualHost>
```

### Setup api for mercure

- create a JWT token with the following payload(body) and the secret key from your mercure config.
```
{
  "mercure": {
    "subscribe": ["*"],
    "publish": ["*"]
  }
}
``` 
subscribe = users that are allowed to listen to the hub & topics

publish = users that are allowed to publish new updates via the hub

- in the api's .env file configure:
```
MERCURE_PUBLISH_URL=http://localhost:3000/hub
MERCURE_JWT_SECRET="your.jwt.token.generated.with.the.secret.key"
```

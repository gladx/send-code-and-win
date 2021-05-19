# Send code and win

## APIs
```
POST /code 
 code: x1400
 quantity: 1000

POST /user/code
    phone : 091012340001
    code : x1400

GET /user/code/{code}/{phone}
```

## Select winners

```
    php artisan update-wins
```
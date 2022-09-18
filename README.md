# Questions test app

## How to run

-   Clone the repo
-   `cd` into repo
-   Spin up docker container:

```
./vendor/bin/sail  up -d
```

-   get into docker container:

```
docker exec -it questions-laravel.test-1 bash
```

-   Run migrations and seed

```
php artisan migrate:fresh --seed
```

## Routes

### - Post new answer

```
POST localhost/api/answers
```

Payload

```
{
	"question_id": int questionId
	"value": string value
}
```

cURL

```
curl --request POST \
  --url http://localhost/api/answers \
  --header 'Accept: application/json' \
  --header 'Content-Type: application/json' \
  --data '{
	"question_id": 1954,
	"value": "5"
}'
```

### - Get questions/answers summary

```
GET localhost/api/questions/summary
```

cURL

```
curl --request GET \
  --url http://localhost/api/questions/summary
```

## The task

Create API with necessary endpoints to populate answers for questions and return results.
Results must contain 10 questions:

-   9 questions with 6 answer options (scalar values 0 - 5)
-   1 open question (free text entry)
    Populate answers to questions - 100k answers per question. Graph question answers must be
    randomized.

### Return data:

#### Graph questions

-   Question average
-   Question answers count
-   Answers per question option

#### Open question

-   Question answers count
-   Word cloud

Symfony Movie App
========================

The application was created for recruitment purposes.

Routes
------------

`GET /movies/recommendations/{recommendationType}`
This endpoint fetches movie recommendations based on the provided recommendation type. The recommendationType is a URL parameter, which is validated and mapped to one of the values from the MovieRecommendationType enum.

Route:

```php

#[Route('/movies/recommendations/{recommendationType}', name: 'app_movie', methods: ['GET'])]
```
Parameters:

* {recommendationType} (string): The type of movie recommendation to fetch. It must match one of the values defined in the MovieRecommendationType enum: random, w_even, or multi_word.

Response:

* 200 OK: Returns a JSON response with the list of movie recommendations.
400 Bad Request: Returns a JSON response with an error message if the recommendationType is invalid or if the movie recommendation strategy is not registered.


### Responses

#### 1. **Valid Request (Example: Random Recommendation)**

**Request**:
```bash
curl -X GET "http://127.0.0.1:8000/movies/recommendations/random"
```

**Response**:
```json
{
    "recommendations": ["Movie 1", "Movie 2", "Movie 3"]
}
```

#### 2. **Invalid Recommendation Type (Example: Unknown Type)**

**Request**:
```bash
curl -X GET "http://127.0.0.1:8000/movies/recommendations/unknown"
```

**Response**:
```json
{
    "error": "Invalid recommendation type 'unknown'. Available options: random, w_even, multi_word"
}
```

#### 3. **Strategy Not Registered (Example: w_even Type)**

**Request**:
```bash
curl -X GET "http://127.0.0.1:8000/movies/recommendations/w_even"
```

**Response**:
```json
{
    "error": "The recommendation strategy was not registered."
}
```

### Enum: `MovieRecommendationType`

The `MovieRecommendationType` enum defines the valid recommendation types:
- `RANDOM`: Returns random movie recommendations.
- `W_EVEN`: Returns recommendations based on a word-even strategy.
- `MULTI_WORD`: Returns recommendations based on multi-word criteria.


Requirements
------------

* PHP 8.3.0 or higher;
* PDO-SQLite PHP extension enabled;
* and the [usual Symfony application requirements][2].

Usage
-----

There's no need to configure anything before running the application. There are
2 different ways of running this application depending on your needs:

[Download Symfony CLI][4] and run this command:

```bash
git clone https://github.com/mtskrzypiec/MovieRecommendationSymfony.git movies_project
cd movies_project/
symfony serve
```

Then access the application in your browser at the given URL (<https://localhost:8000> by default).


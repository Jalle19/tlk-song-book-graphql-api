# GraphQL API for the TLK song book

[![Build Status](https://travis-ci.org/Jalle19/tlk-song-book-graphql-api.svg?branch=master)](https://travis-ci.org/Jalle19/tlk-song-book-graphql-api)

A basic GraphQL API that exposes the TLK song book. You can use the API at https://stormy-sea-43891.herokuapp.com/

## Requirements

* PHP >= 7.1
* ext-mbstring

## Installation (for development)

* Run `composer install`
* Run `php -S localhost:8080 -t public/`
 
Browse the API at http://localhost:8080/

## Example queries

Retrieve a list of all categories:

```graphql
{
  categories {
    edges {
      node {
        id
        name
      }
    }
  }
}
```

Retrieve a list of all songs in a specific category:

```graphql
{
  category(id: 1) {
    songs {
      edges {
        node {
          id
          name
          notes
          text
        }
      }
    }
  }
}
```

Find all songs containing the word "drick":

```graphql
{
  songs(search: {text: "helvete"}) {
    edges {
      node {
        id
        name
      }
    }
  }
}
```

## License

See the LICENSE file

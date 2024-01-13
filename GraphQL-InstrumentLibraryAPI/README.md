# Introduction

This project is a GraphQL cloud service implemented in Node.js. It facilitates the buying and selling of musical instruments through posts. Users can create selling posts with details about the instrument they want to sell, and potential buyers can query and filter posts to find instruments of interest.

The service utilizes Apollo Server for GraphQL implementation and leverages GraphQL's flexibility in querying specific data needs. The underlying data is managed through resolvers, providing efficient data retrieval.

[Apollo Server](https://www.apollographql.com/docs/apollo-server/) is a community-driven, open-source GraphQL server that works with any GraphQL schema. It simplifies the process of building GraphQL servers.

[graphql](https://graphql.org/) is a query language for APIs and a runtime for executing those queries against your data. It allows clients to request only the data they need, providing a more efficient and flexible alternative to traditional REST APIs.

# Running the server

Before running the server, make sure to install the necessary dependencies using the following command:
```console
npm install
```

Start the server by running the following command:
```Console
npm start
```

The server will be accessible at the specified address (standard http://localhost:4000). You can use tools like Apollo Playground or Rested to interact with the GraphQL API

# Usage

## Queries

### instrumentPosts 

get all stored instrument posts

```graphql
query {
  instrumentPosts {
    // Fields to retrieve
  }
}
```

### instrumentTypes

get all stored instrument types

```graphql
query {
  instrumentTypes {
    // Fields to retrieve
  }
}
```

### locations

get all stored locations

```graphql
query {
  locations {
    // Fields to retrieve
  }
}
```

### instrumentPostwithID

Get an instrument post by its unique ID.

```graphql
query {
  instrumentPostwithID(id: "uniqueID") {
    // Fields to retrieve
  }
}
```

### filterInstrumentPosts

Filter instrument posts based on specified criteria.

```graphql
query {
  filterInstrumentPosts(
    sellerUserName: "username"
    instrumentType: "type"
    instrumentFamily: STRING
    locationName: "location"
    condition: NEW
    priceMin: 100
    priceMax: 500
  ) {
    // Fields to retrieve
  }
}
```

### filterInstrumentTypes

Filter instrument types based on the instrument family.

```graphql
query {
  filterInstrumentTypes(instrumentFamily: STRING) {
    // Fields to retrieve
  }
}
```

## Mutations

### createInstrumentPost

Create a new instrument post.


```graphql
mutation {
  createInstrumentPost(
    title: "Title"
    description: "Description"
    imageUrl: "Image URL"
    type: "Type"
    age: 3
    condition: NEW
    price: 300.5
    location: { city: "City" }
    seller: { userID: 1, userName: "Username", email: "user@example.com" }
  ) {
    // Fields to retrieve
  }
}
```

### deleteInstrumentPost

Delete an instrument post by its ID.

```graphql
mutation {
  deleteInstrumentPost(postID: 1) {
    // Fields to retrieve
  }
}
```

## Types and Enumerations


### User
```console
type User {
  userID: Int!
  userName: String!
  email: String!
  instrumentsForSale: [InstrumentPost]!
}
```

### UserInput
```console
input UserInput {
  userID: Int!
  userName: String!
  email: String!
}
```

### InstrumentPost
```console
type InstrumentPost {
  id: ID!
  title: String!
  description: String!
  imageUrl: String!
  type: InstrumentType!
  age: Int!
  condition: InstrumentCondition!
  price: Float!
  location: Location!
  seller: User!
}
```

### Location
```console
type Location {
  city: String!
  instrumentsForSale: [InstrumentPost]!
}
```

### LocationInput
```console
input LocationInput {
  city: String!
}
```

### InstrumentType
```console
type InstrumentType {
  name: String!
  family: InstrumentFamily!
  instrumentsForSale: [InstrumentPost]!
}
```

### InstrumentFamily (Enumeration)
```console
enum InstrumentFamily {
  Strings
  Woodwind
  Brass
  Percussion
  Electronic
}
```

### InstrumentCondition (Enumeration)
```console
enum InstrumentCondition {
  NEW
  USED
  OLD
}
```
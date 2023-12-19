/**
 * Sources: 
 * https://www.apollographql.com/docs/apollo-server/getting-started
 */

const { readFileSync } = require('fs');
const { ApolloServer } = require('@apollo/server');
const { startStandaloneServer } = require('@apollo/server/standalone');

const resolvers = require('./Resolvers');
const typeDefs = readFileSync('./src/InstrumentLibraryAPI.graphql', 'utf-8');

const server = new ApolloServer({
  typeDefs,
  resolvers,
});
  
startStandaloneServer(server, {
  listen: { port: 4000 },
})
.then(({ url }) => {
  console.log(`🚀  Server ready at: ${url}`);
});
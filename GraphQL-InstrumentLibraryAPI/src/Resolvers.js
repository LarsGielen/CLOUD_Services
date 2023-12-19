const dataLoader = require('./DataLoader');

const InstrumentPosts = dataLoader.loadInstrumentPosts();
const InstrumentTypes = dataLoader.loadInstrumentTypes();
const Users = dataLoader.loadUsers();

// Query Resolvers
const queryResolver = {
    instrumentPosts: () => InstrumentPosts,
    instrumentTypes: () => InstrumentTypes,
    locations: getAllLocations,

    instrumentPostwithID: getInstrumentPostByID,
    filterInstrumentPosts: filterInstrumentPosts,
}

function getAllLocations() {
    const locationSet = new Set();
    Users.forEach(user => locationSet.add(user.location));
    InstrumentPosts.forEach(instrumentPost => locationSet.add(instrumentPost.location));
    return [...locationSet].map(location => ({city: location}));
}

function getInstrumentPostByID(parent, args) {
    return InstrumentPosts.find(instrumentPost => instrumentPost.id == args.id);
}

function filterInstrumentPosts(parent, args) {
    var filtered = InstrumentPosts;

    if (args.sellerUserName) {
        filtered = filtered.filter(instrumentPost => instrumentPost.sellerUserName == args.sellerUserName);
    }

    if (args.instrumentType) {
        filtered = filtered.filter(instrumentPost => instrumentPost.type == args.instrumentType);
    }

    if (args.instrumentFamily) {
        const instrumentTypeNames = filterInstrumentTypes(parent, args).map(type => type.name);
        filtered = filtered.filter(instrumentPost => instrumentTypeNames.includes(instrumentPost.type));
    }

    if (args.locationName) {
        filtered = filtered.filter(instrumentPost => instrumentPost.location == args.locationName);
    }

    if (args.condition) {
        filtered = filtered.filter(instrumentPost => instrumentPost.condition == args.condition);
    }

    if (args.priceMin) {
        filtered = filtered.filter(instrumentPost => instrumentPost.price >= args.priceMin);
    }

    if (args.priceMax) {
        filtered = filtered.filter(instrumentPost => instrumentPost.price <= args.priceMax);
    }

    return filtered;
}

function filterInstrumentTypes(parent, args) {
    var filtered = InstrumentTypes;

    if (args.instrumentFamily) {
        filtered = filtered.filter(type => type.family == args.instrumentFamily);
    }

    return filtered;
}

// Resolvers for type defentitions
userResolver = {
    instrumentsForSale: (parent) => {
        return InstrumentPosts.filter(instrumentPost => instrumentPost.sellerUserName == parent.userName);
    },
}

instrumentPostResolver = {
    seller: (parent) => {
        return Users.find(user => user.userName == parent.sellerUserName);
    },

    location: (parent) => {
        return {city: parent.location};
    },

    type: (parent) => {
        return InstrumentTypes.find(instrumentType => instrumentType.name == parent.type);
    }
}

locationResolver = {
    instrumentsForSale: (parent) => {
        return InstrumentPosts.filter(instrumentPost => instrumentPost.location == parent.city);
    },
}

instrumentTypeResolver = {
    instrumentsForSale: (parent) => {
        return InstrumentPosts.filter(instrumentPost => instrumentPost.type == parent.name);
    }
}

// Create resolvers object
const resolvers = {
    Query: queryResolver,
    User: userResolver,
    InstrumentPost: instrumentPostResolver,
    Location: locationResolver,
    InstrumentType: instrumentTypeResolver,
}

module.exports = resolvers;
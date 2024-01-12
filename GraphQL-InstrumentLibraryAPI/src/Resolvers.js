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
    filterInstrumentTypes: filterInstrumentTypes,
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

// Mutation Resolvers
const mutationResolver = {
    createInstrumentPost: createInstrumentPost,
    deleteInstrumentPost: deleteInstrumentPost,
}

function createInstrumentPost(parent, args) {
    var seller = {
        userID: parseInt(args.seller.userID),
        userName: args.seller.userName,
        email: args.seller.email,
    }

    var post = {
        id: InstrumentPosts.length + 1,
        title: args.title,
        imageUrl: args.imageUrl,
        description: args.description,
        type: args.type,
        age: parseFloat(args.age),
        condition: args.condition,
        price: parseFloat(args.price),
        location: args.location.city,
        sellerUserID: seller.userID
    }

    let userIndex = Users.findIndex((user) => user.userID === seller.userID);
    if (userIndex != -1) {
        Users.push(seller);
    }

    InstrumentPosts.push(post);
    return post;
}

function deleteInstrumentPost(parent, args) {
    let index = InstrumentPosts.findIndex((post) => post.id === args.postID);

    if (index == -1) {
        return null;
    }

    var post = InstrumentPosts.at(index);
    InstrumentPosts.splice(index, 1);
    return post;
}

// Resolvers for type defentitions
userResolver = {
    instrumentsForSale: (parent) => {
        return InstrumentPosts.filter(instrumentPost => instrumentPost.sellerUserID == parent.userID);
    },
}

instrumentPostResolver = {
    seller: (parent) => {
        return Users.find(user => user.userID == parent.sellerUserID);
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
    Mutation: mutationResolver,
    User: userResolver,
    InstrumentPost: instrumentPostResolver,
    Location: locationResolver,
    InstrumentType: instrumentTypeResolver,
}

module.exports = resolvers;
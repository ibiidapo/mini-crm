var Ziggy = {
  namedRoutes: {
    'home': {
      'uri': 'home',
      'methods': ['GET', 'HEAD'],
      'domain': null,
    },
    'index': {
      'uri': '\/',
      'methods': ['GET', 'HEAD'],
      'domain': null,
    },
    'login': {
      'uri': 'login',
      'methods': ['GET', 'HEAD'],
      'domain': null,
    },
    'logout': {
      'uri': 'logout',
      'methods': ['POST'],
      'domain': null,
    },
    'password.request': {
      'uri': 'password\/reset',
      'methods': ['GET', 'HEAD'],
      'domain': null,
    },
    'password.email': {
      'uri': 'password\/email',
      'methods': ['POST'],
      'domain': null,
    },
    'password.reset': {
      'uri': 'password\/reset\/{token}',
      'methods': ['GET', 'HEAD'],
      'domain': null,
    },
    'password.update': {
      'uri': 'password\/reset',
      'methods': ['POST'],
      'domain': null,
    },
    'clients.index': {
      'uri': 'clients',
      'methods': ['GET', 'HEAD'],
      'domain': null,
    },
    'clients.create': {
      'uri': 'clients\/create',
      'methods': ['GET', 'HEAD'],
      'domain': null,
    },
    'clients.store': {
      'uri': 'clients',
      'methods': ['POST'],
      'domain': null,
    },
    'clients.show': {
      'uri': 'clients\/{client}',
      'methods': ['GET', 'HEAD'],
      'domain': null,
    },
    'clients.edit': {
      'uri': 'clients\/{client}\/edit',
      'methods': ['GET', 'HEAD'],
      'domain': null,
    },
    'clients.update': {
      'uri': 'clients\/{client}',
      'methods': ['PUT', 'PATCH'],
      'domain': null,
    },
    'clients.destroy': {
      'uri': 'clients\/{client}',
      'methods': ['DELETE'],
      'domain': null,
    },
    'transactions.index': {
      'uri': 'transactions',
      'methods': ['GET', 'HEAD'],
      'domain': null,
    },
    'transactions.create': {
      'uri': 'transactions\/create',
      'methods': ['GET', 'HEAD'],
      'domain': null,
    },
    'transactions.store': {
      'uri': 'transactions',
      'methods': ['POST'],
      'domain': null,
    },
    'transactions.show': {
      'uri': 'transactions\/{transaction}',
      'methods': ['GET', 'HEAD'],
      'domain': null,
    },
    'transactions.edit': {
      'uri': 'transactions\/{transaction}\/edit',
      'methods': ['GET', 'HEAD'],
      'domain': null,
    },
    'transactions.update': {
      'uri': 'transactions\/{transaction}',
      'methods': ['PUT', 'PATCH'],
      'domain': null,
    },
    'transactions.destroy': {
      'uri': 'transactions\/{transaction}',
      'methods': ['DELETE'],
      'domain': null,
    },
  },
  baseUrl: 'http://mini-crm.localhost/',
  baseProtocol: 'http',
  baseDomain: 'mini-crm.localhost',
  basePort: false,
  defaultParameters: [],
};

export {
  Ziggy,
};

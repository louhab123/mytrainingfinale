
export const getHomeRouteForLoggedInUser = role  => {
    if (role === 'admin') return next({ name: 'dashboard' });
    if (role === 'agent') return next({ name: 'espace-agent' });
    if (role === 'client') return next({name: 'espace-client' });
    if (role === 'formateur') return next({name: 'espace-formateur'});
  }

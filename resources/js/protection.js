const token = localStorage.getItem('token') ? localStorage.getItem('token') : null;

function checkIsAuth(to, from, next) {
    if (!token) {
      next('/');
    } else {
      next();
    }
  }
  
  function checkIsGuest(to, from, next) {
    if (token) {
      next('/clients')
    } else {
      next();
    }
  }

  export {
    checkIsAuth,
    checkIsGuest,
  }
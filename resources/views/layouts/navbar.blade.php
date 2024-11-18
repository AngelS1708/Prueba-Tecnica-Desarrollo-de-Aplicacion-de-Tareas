<style>
:root{
    --bs-secondary: #2c3e50;
  }
#mainNav {
  padding-top: 1rem;
  padding-bottom: 1rem;
  font-family: "Montserrat", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
  font-weight: 700;
}
#mainNav .navbar-brand {
  color: #fff;
}
#mainNav .navbar-nav {
  margin-top: 1rem;
}
#mainNav .navbar-nav li.nav-item a.nav-link {
  color: #fff;
}
#mainNav .navbar-nav li.nav-item a.nav-link:hover {
  color: #1abc9c;
}
#mainNav .navbar-nav li.nav-item a.nav-link:active, #mainNav .navbar-nav li.nav-item a.nav-link:focus {
  color: #fff;
}
#mainNav .navbar-nav li.nav-item a.nav-link.active {
  color: #1abc9c;
}
#mainNav .navbar-toggler {
  font-size: 80%;
  padding: 0.8rem;
}

@media (min-width: 992px) {
  #mainNav {
    padding-top: 1.5rem;
    padding-bottom: 1.5rem;
    transition: padding-top 0.3s, padding-bottom 0.3s;
  }
  #mainNav .navbar-brand {
    font-size: 1.75em;
    transition: font-size 0.3s;
  }
  #mainNav .navbar-nav {
    margin-top: 0;
  }
  #mainNav .navbar-nav > li.nav-item > a.nav-link.active {
    color: #fff;
    background: #1abc9c;
  }
  #mainNav .navbar-nav > li.nav-item > a.nav-link.active:active, #mainNav .navbar-nav > li.nav-item > a.nav-link.active:focus, #mainNav .navbar-nav > li.nav-item > a.nav-link.active:hover {
    color: #fff;
    background: #1abc9c;
  }
  #mainNav.navbar-shrink {
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
  }
  #mainNav.navbar-shrink .navbar-brand {
    font-size: 1.5em;
  }
}
</style>

<nav style="background-color: #2c3e50" class="navbar navbar-expand-lg text-uppercase fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="#page-top">Control de Tareas
        </a>
        <button class="navbar-toggler text-uppercase font-weight-bold text-white rounded" style="background-color: #4c6987" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="">Tareas</a></li>
                <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="">Administrador de tareas</a></li>    
            </ul>
        </div>
    </div>
</nav>
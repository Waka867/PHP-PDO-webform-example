<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Record Entry System</title>
    <script crossorigin src="https://unpkg.com/react@16/umd/react.production.min.js"></script>
    <script crossorigin src="https://unpkg.com/react-dom@16/umd/react-dom.production.min.js"></script>
    <!-- <script crossorigin src="https://unpkg.com/react@16/umd/react.development.js"></script>
    <script crossorigin src="https://unpkg.com/react-dom@16/umd/react-dom.development.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-standalone/6.21.1/babel.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="nav.js"></script>
    <script type="text/babel">
      const Header = () => {
        return (
          <nav id='nav'>
            <div>
              <img id='site-logo' src='' />
          	  <p id='site-title'>Record Entry System</p>
              <a href='/'><button>Home</button></a>
              {/*<a href='#'><button>Report</button></a>*/}
            </div>
          </nav>
        );
  		}

  		ReactDOM.render(<Header/>, document.getElementById('header'));
    </script>
  </head>
  <body>
    <div id='header'>
    </div>
    <noscript style="font-size: 2em; color: red;">Error: To use this form Javascript must be enabled!</noscript>

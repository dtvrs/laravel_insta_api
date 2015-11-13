<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="http://v4-alpha.getbootstrap.com/favicon.ico">

    <title>Fixed top navbar example for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="http://v4-alpha.getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="http://v4-alpha.getbootstrap.com/assets/js/ie10-viewport-bug-workaround.js"></script>
  </head>

  <body>

    <!--<div class="pos-f-t">
      <div class="collapse" id="navbar-header">
        <div class="container-fluid inverse p-a">
          <h3>Collapsed content</h3>
          <p>Toggleable via the navbar brand.</p>
        </div>
      </div>
      <div class="navbar navbar-default navbar-static-top">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-header">
          ☰
        </button>
      </div>
    </div>-->

    <div class="container">
      <div class="jumbotron">
        <h1>#portugal</h1>
        <!--<p class="lead">This example is a quick exercise to illustrate how fixed to top navbar works. As you scroll, it will remain fixed to the top of your browser's viewport.</p>
        <a class="btn btn-lg btn-primary" href="http://v4-alpha.getbootstrap.com/components/#navbar" role="button">View navbar docs »</a>-->
        <!-- Carousel container -->
        <div id="my-pics" class="carousel slide" data-ride="carousel">

        <!-- Indicators -->
        <!--<ol class="carousel-indicators">
        <li data-target="#my-pics" data-slide-to="0" class="active"></li>
        <li data-target="#my-pics" data-slide-to="1"></li>
        <li data-target="#my-pics" data-slide-to="2"></li>
      </ol>-->

        <!-- Content -->
        <div class="carousel-inner" role="listbox">

        @foreach ($items as $item)
          <div class="carousel-item">
          <img src="{{ $item['online_location'] }}" alt="Sunset over beach">
          <div class="carousel-caption">
              <h3>
                  {{$item['user_data']['username']}}
                  @if (!empty($item['user_data']['full_name']))
                    - {{$item['user_data']['full_name']}}
                  @endif
                </h3>
              <p>{{ $item['text']}}</p>
              @if (isset($item['location_data']))
                <p>{{$item['location_data']['name']}}</p>
              @endif
            </div>
          </div>
        @endforeach
        <!-- Slide 1 -->

        </div>

        <!-- Previous/Next controls -->
        <a class="left carousel-control" href="#my-pics" role="button" data-slide="prev">
        <span class="icon-prev" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#my-pics" role="button" data-slide="next">
        <span class="icon-next" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
        </a>

        </div>
      </div>
    </div>

    <!-- Center the image -->
    <style scoped>
      .carousel-item img{
          margin: 0 auto;
      }
    </style>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://v4-alpha.getbootstrap.com/dist/js/bootstrap.min.js"></script>
    <script>
      $(document).ready(function(){
        $('.carousel-item').first().addClass('active');
      });
    </script>

  </body>
</html>

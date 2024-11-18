<?php
include_once 'includes/functions.php';

include_once 'includes/header.php';
?>

<div id="hero" class="text-center">
    <div class="container my-5">
            <h1>What are you Searching for?</h1> 
            <div class="input-group my-5">
            <input type="text" class="form-control form-control-lg text-center" placeholder="Search..." data-bs-toggle="modal" data-bs-target="#searchModal">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Search
            </button>
        </div>

        <div class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Modal body text goes here.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
            </div>
        </div>
        </div>
    </div>
</div>

<div id="exclusive-section" class="container mt-5">
<div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <div class="row">
        <div class="col-4">
          <div class="card">
            <img src="..." class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title">Card 1</h5>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
          </div>
        </div>
        <div class="col-4">
          <div class="card">
            <img src="..." class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title">Card 2</h5>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
          </div>
        </div>
        <div class="col-4">
          <div class="card">
            <img src="..." class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title">Card 3</h5>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="carousel-item">
      <div class="row">
        <div class="col-4">
          <div class="card">
            <img src="..." class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title">Card 4</h5>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
          </div>
        </div>
        <div class="col-4">
          <div class="card">
            <img src="..." class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title">Card 5</h5>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
          </div>
        </div>
        <div class="col-4">
          <div class="card">
            <img src="..." class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title">Card 6</h5>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="carousel-item">
      <div class="row">
        <div class="col-4">
          <div class="card">
            <img src="..." class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title">Card 7</h5>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
          </div>
        </div>
        <div class="col-4">
          <div class="card">
            <img src="..." class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title">Card 8</h5>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
          </div>
        </div>
        <div class="col-4">
          <div class="card">
            <img src="..." class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title">Card 9</h5>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Carousel Controls placed outside the carousel -->
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev" style="border: none; background: transparent;">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next" style="border: none; background: transparent;">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

</div>



<div id="genres-section" class="container my-4">
  <div class="row text-center">
  <h2 class="h5 my-4">Most Popular Genres</h2>
    <!-- Genre 1 -->
    <div class="col-6 col-md-4 col-lg-2 mb-4">
      <div class="card text-center">
        <img src="https://via.placeholder.com/150" alt="Genre Image" class="card-img-top">
        <div class="card-body">
          <h5 class="card-title">Action</h5>
        </div>
      </div>
    </div>
    <!-- Genre 2 -->
    <div class="col-6 col-md-4 col-lg-2 mb-4">
      <div class="card text-center">
        <img src="https://via.placeholder.com/150" alt="Genre Image" class="card-img-top">
        <div class="card-body">
          <h5 class="card-title">Adventure</h5>
        </div>
      </div>
    </div>
    <!-- Genre 3 -->
    <div class="col-6 col-md-4 col-lg-2 mb-4">
      <div class="card text-center">
        <img src="https://via.placeholder.com/150" alt="Genre Image" class="card-img-top">
        <div class="card-body">
          <h5 class="card-title">Comedy</h5>
        </div>
      </div>
    </div>
    <!-- Genre 4 -->
    <div class="col-6 col-md-4 col-lg-2 mb-4">
      <div class="card text-center">
        <img src="https://via.placeholder.com/150" alt="Genre Image" class="card-img-top">
        <div class="card-body">
          <h5 class="card-title">Drama</h5>
        </div>
      </div>
    </div>
    <!-- Genre 5 -->
    <div class="col-6 col-md-4 col-lg-2 mb-4">
      <div class="card text-center">
        <img src="https://via.placeholder.com/150" alt="Genre Image" class="card-img-top">
        <div class="card-body">
          <h5 class="card-title">Horror</h5>
        </div>
      </div>
    </div>
    <!-- Genre 6 -->
    <div class="col-6 col-md-4 col-lg-2 mb-4">
      <div class="card text-center">
        <img src="https://via.placeholder.com/150" alt="Genre Image" class="card-img-top">
        <div class="card-body">
          <h5 class="card-title">Romance</h5>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<div id="popular-section" class="container">
<div class="row text-center">
<h2 class="h5 my-4">Most Popular Books</h2>
    <div class="col">
      <div class="card">
        <img src="https://via.placeholder.com/150" class="card-img-top" alt="Book 1">
        <div class="card-body">
          <h5 class="card-title">Book Title 1</h5>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card">
        <img src="https://via.placeholder.com/150" class="card-img-top" alt="Book 2">
        <div class="card-body">
          <h5 class="card-title">Book Title 2</h5>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card">
        <img src="https://via.placeholder.com/150" class="card-img-top" alt="Book 3">
        <div class="card-body">
          <h5 class="card-title">Book Title 3</h5>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card">
        <img src="https://via.placeholder.com/150" class="card-img-top" alt="Book 3">
        <div class="card-body">
          <h5 class="card-title">Book Title 4</h5>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card">
        <img src="https://via.placeholder.com/150" class="card-img-top" alt="Book 3">
        <div class="card-body">
          <h5 class="card-title">Book Title 5</h5>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card">
        <img src="https://via.placeholder.com/150" class="card-img-top" alt="Book 3">
        <div class="card-body">
          <h5 class="card-title">Book Title 6</h5>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card">
        <img src="https://via.placeholder.com/150" class="card-img-top" alt="Book 3">
        <div class="card-body">
          <h5 class="card-title">Book Title 7</h5>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card">
        <img src="https://via.placeholder.com/150" class="card-img-top" alt="Book 3">
        <div class="card-body">
          <h5 class="card-title">Book Title 8</h5>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card">
        <img src="https://via.placeholder.com/150" class="card-img-top" alt="Book 3">
        <div class="card-body">
          <h5 class="card-title">Book Title 9</h5>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card">
        <img src="https://via.placeholder.com/150" class="card-img-top" alt="Book 3">
        <div class="card-body">
          <h5 class="card-title">Book Title 10</h5>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="contact-sektion" class="container mt-5 text-center">
  <div class="row">
    <div class="col">
    <h2>Did you find what you need</h2>
    <p class="mt-2 mb-0">No problem, we rake all requests to heart.</p>
    <p class="mb-2">Big or small</p>
    <a href="contact.php" class="btn btn-primary btn-lg" role="button">Make a Request</a>
    </div>
  </div>
</div>

<div id="about-section" class="container my-5">
<div class="row">
    <div class="col-6">
    <h2>About Qvintus</h2>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
    </div>
    <div class="col-6 d-flex justify-content-center align-items-center">
  <img style="width: auto; height: 400px;" src="images/qvintus.webp" alt="Old man and Owner">
</div>
  </div>
</div>

<div id="customer-section" class="container">
<div class="row text-center my-5">
<h2 class="h5 my-4">Customer Stories</h2>
  <div class="col-3">
      <div class="card text-center">
        <img src="https://via.placeholder.com/150" alt="Genre Image" class="card-img-top">
        <div class="card-body">
          <h5 class="card-title">Pekka</h5>
        </div>
      </div>
    </div>
    <div class="col-3">
      <div class="card text-center">
        <img src="https://via.placeholder.com/150" alt="Genre Image" class="card-img-top">
        <div class="card-body">
          <h5 class="card-title">Dr.William</h5>
        </div>
      </div>
    </div>
    <div class="col-3">
      <div class="card text-center">
        <img src="https://via.placeholder.com/150" alt="Genre Image" class="card-img-top">
        <div class="card-body">
          <h5 class="card-title">Jin-din</h5>
        </div>
      </div>
    </div>
  </div>
</div>


<?php
include_once 'includes/footer.php';
?>
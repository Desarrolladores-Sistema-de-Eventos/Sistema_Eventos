<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Cursos</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="../public/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet"> 

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../public/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="../public/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../public/css/style.css" rel="stylesheet">
</head>

<body>
    <?php include('partials/header.php'); ?>
    <!-- Header Start -->
    <div class="container-fluid page-header">
        <div class="container">
            <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 400px">
                <h3 class="display-4 text-white text-uppercase">Cursos</h3>
                <div class="d-inline-flex text-white">
                    <p class="m-0 text-uppercase"><a class="text-white" href="">Home</a></p>
                    <i class="fa fa-angle-double-right pt-1 px-3"></i>
                    <p class="m-0 text-uppercase">Cursos</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->


    <!-- Booking Start -->
    <div class="container-fluid booking mt-5 pb-5">
        <div class="container pb-5">
            <div class="bg-light shadow" style="padding: 30px;">
                <div class="row align-items-center" style="min-height: 60px;">
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3 mb-md-0">
                                    <select class="custom-select px-4" style="height: 47px;">
                                        <option selected>Destination</option>
                                        <option value="1">Destination 1</option>
                                        <option value="2">Destination 1</option>
                                        <option value="3">Destination 1</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3 mb-md-0">
                                    <div class="date" id="date1" data-target-input="nearest">
                                        <input type="text" class="form-control p-4 datetimepicker-input" placeholder="Depart Date" data-target="#date1" data-toggle="datetimepicker"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3 mb-md-0">
                                    <div class="date" id="date2" data-target-input="nearest">
                                        <input type="text" class="form-control p-4 datetimepicker-input" placeholder="Return Date" data-target="#date2" data-toggle="datetimepicker"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3 mb-md-0">
                                    <select class="custom-select px-4" style="height: 47px;">
                                        <option selected>Duration</option>
                                        <option value="1">Duration 1</option>
                                        <option value="2">Duration 1</option>
                                        <option value="3">Duration 1</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary btn-block" type="submit" style="height: 47px; margin-top: -2px;">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Booking End -->

    
   <!-- Cursos Start -->
<div class="container-fluid py-5">
    <div class="container pt-5 pb-3">
        <div class="text-center mb-3 pb-3">
            <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Eventos</h6>
            <h1>Cursos</h1>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="package-item bg-white mb-2">
                    <div style="font-weight: bold; color: #d9534f; font-size: 14px; margin-bottom: 5px;">
                        ABIERTO
                    </div>
                    <img class="img-fluid" src="img/package-1.jpg" alt="">
                    <div class="p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <small class="m-0">
                                <i class="fas fa-book-open text-primary mr-2"></i>Curso
                            </small>
                            <small class="m-0">
                                <i class="fas fa-hourglass-half text-primary mr-2"></i>Duración
                            </small>
                            <small class="m-0">
                                <i class="fas fa-user-graduate text-primary mr-2"></i>Estudiantes
                            </small>
                        </div>
                        <a class="h5 text-decoration-none" href="">Discover amazing places of the world with us</a>
                        <div class="border-top mt-4 pt-4">
                            <div class="d-flex justify-content-between">
                                <h6 class="m-0">
                                    <i class="fas fa-star text-primary mr-2"></i>4.5 <small>(250)</small>
                                </h6>
                                <h5 class="m-0">$350</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Repite para las demás tarjetas -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="package-item bg-white mb-2">
                    <div style="font-weight: bold; color: #d9534f; font-size: 14px; margin-bottom: 5px;">
                        ABIERTO
                    </div>
                    <img class="img-fluid" src="img/package-2.jpg" alt="">
                    <div class="p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <small class="m-0">
                                <i class="fas fa-book-open text-primary mr-2"></i>Curso
                            </small>
                            <small class="m-0">
                                <i class="fas fa-hourglass-half text-primary mr-2"></i>Duración
                            </small>
                            <small class="m-0">
                                <i class="fas fa-user-graduate text-primary mr-2"></i>Estudiantes
                            </small>
                        </div>
                        <a class="h5 text-decoration-none" href="">Discover amazing places of the world with us</a>
                        <div class="border-top mt-4 pt-4">
                            <div class="d-flex justify-content-between">
                                <h6 class="m-0">
                                    <i class="fas fa-star text-primary mr-2"></i>4.5 <small>(250)</small>
                                </h6>
                                <h5 class="m-0">$350</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Continúa con las otras tarjetas -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="package-item bg-white mb-2">
                    <div style="font-weight: bold; color: #d9534f; font-size: 14px; margin-bottom: 5px;">
                        ABIERTO
                    </div>
                    <img class="img-fluid" src="img/package-3.jpg" alt="">
                    <div class="p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <small class="m-0">
                                <i class="fas fa-book-open text-primary mr-2"></i>Curso
                            </small>
                            <small class="m-0">
                                <i class="fas fa-hourglass-half text-primary mr-2"></i>Duración
                            </small>
                            <small class="m-0">
                                <i class="fas fa-user-graduate text-primary mr-2"></i>Estudiantes
                            </small>
                        </div>
                        <a class="h5 text-decoration-none" href="">Discover amazing places of the world with us</a>
                        <div class="border-top mt-4 pt-4">
                            <div class="d-flex justify-content-between">
                                <h6 class="m-0">
                                    <i class="fas fa-star text-primary mr-2"></i>4.5 <small>(250)</small>
                                </h6>
                                <h5 class="m-0">$350</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="package-item bg-white mb-2">
                    <div style="font-weight: bold; color: #d9534f; font-size: 14px; margin-bottom: 5px;">
                        ABIERTO
                    </div>
                    <img class="img-fluid" src="img/package-6.jpg" alt="">
                    <div class="p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <small class="m-0">
                                <i class="fas fa-book-open text-primary mr-2"></i>Curso
                            </small>
                            <small class="m-0">
                                <i class="fas fa-hourglass-half text-primary mr-2"></i>Duración
                            </small>
                            <small class="m-0">
                                <i class="fas fa-user-graduate text-primary mr-2"></i>Estudiantes
                            </small>
                        </div>
                        <a class="h5 text-decoration-none" href="">Discover amazing places of the world with us</a>
                        <div class="border-top mt-4 pt-4">
                            <div class="d-flex justify-content-between">
                                <h6 class="m-0">
                                    <i class="fas fa-star text-primary mr-2"></i>4.5 <small>(250)</small>
                                </h6>
                                <h5 class="m-0">$350</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Cursos End -->

    <?php include('partials/footer.php'); ?>
    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="../public/lib/easing/easing.min.js"></script>
    <script src="../public/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="../public/lib/tempusdominus/js/moment.min.js"></script>
    <script src="../public/lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="../public/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="../public/mail/jqBootstrapValidation.min.js"></script>
    <script src="../public/mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="../public/js/main.js"></script>
</body>

</html>
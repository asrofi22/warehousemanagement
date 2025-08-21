<?php echo $this->extend($config->viewLayout) ?>
<?php echo $this->section('main') ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<title>Login - Sistem Informasi Manajemen Gudang</title>
	<!--favicon-->
	<link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" />
	<!-- loader-->
	<link href="assets/css/pace.min.css" rel="stylesheet" />
	<script src="assets/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet"
		href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&family=Roboto:wght@400;500;700&display=swap" />
	<!-- Icons CSS -->
	<link rel="stylesheet" href="assets/css/icons.css" />
	<!-- App CSS -->
	<link rel="stylesheet" href="assets/css/app.css" />
	<!-- Three.js for 3D background -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
	<!-- Custom CSS for neat appearance and 3D background -->
	<style>
		.section-authentication-login {
			margin-top: 0 !important;
			padding-top: 0 !important;
			min-height: 100vh;
			position: relative;
		}

		.wrapper {
			padding-top: 0 !important;
			background: transparent;
		}

		body.bg-login {
			padding-top: 0 !important;
			background: linear-gradient(135deg, #1e3c72, #2a5298);
			overflow: hidden;
		}

		.card.radius-15 {
			min-height: 650px;
			width: 100%;
			background: #ffffff;
			box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
			border-radius: 20px;
			transition: box-shadow 0.3s ease, transform 0.3s ease;
		}

		.card.radius-15:hover {
			box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
			transform: translateY(-5px);
			/* Subtle lift effect instead of 3D */
		}

		.card-body {
			padding: 2rem 2.5rem;
			display: flex;
			flex-direction: column;
			justify-content: center;
		}

		.card-body .welcome-message {
			font-size: 1.8rem;
			font-weight: 700;
			color: #1e3c72;
			margin-bottom: 1.5rem;
			font-family: 'Roboto', sans-serif;
			text-align: center;
		}

		.card-body h3 {
			font-size: 1.4rem;
			font-weight: 600;
			color: #2a5298;
			margin-bottom: 2rem;
			font-family: 'Roboto', sans-serif;
			text-align: center;
		}

		.form-body {
			max-width: 400px;
			margin: 0 auto;
			padding: 0 1rem;
		}

		.form-label {
			font-size: 0.9rem;
			font-weight: 500;
			color: #1e3c72;
			margin-bottom: 0.5rem;
		}

		.form-control {
			font-size: 0.9rem;
			padding: 0.75rem;
			border-radius: 8px;
			border: 1px solid #ced4da;
			height: 40px;
			transition: border-color 0.3s ease, box-shadow 0.3s ease;
		}

		.form-control:focus {
			border-color: #2a5298;
			box-shadow: 0 0 6px rgba(42, 82, 152, 0.2);
		}

		.form-control.is-invalid {
			border-color: #dc3545;
		}

		.invalid-feedback {
			font-size: 0.8rem;
			color: #dc3545;
			text-align: left;
		}

		.btn-primary {
			font-size: 0.9rem;
			padding: 0.75rem 1.5rem;
			border-radius: 8px;
			background-color: #2a5298;
			border: none;
			transition: background-color 0.3s ease, transform 0.2s ease;
		}

		.btn-primary:hover {
			background-color: #1e3c72;
			transform: translateY(-2px);
		}

		.input-group {
			display: flex;
			align-items: center;
		}

		.input-group-text {
			border-radius: 0 8px 8px 0;
			background-color: #f8f9fa;
			padding: 0.75rem;
			height: 40px;
			display: flex;
			align-items: center;
			justify-content: center;
			border: 1px solid #ced4da;
			border-left: none;
		}

		.form-check {
			margin-bottom: 0.75rem;
		}

		.form-check-label {
			font-size: 0.85rem;
			color: #1e3c72;
		}

		.form-check-input {
			margin-top: 0.3rem;
		}

		.bg-login-color {
			background-color: #e9ecef;
		}

		.bg-login-color img {
			width: 100%;
			height: 100%;
			object-fit: cover;
			border-top-right-radius: 20px;
			border-bottom-right-radius: 20px;
		}

		#three-canvas {
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			z-index: -1;
		}

		@media (max-width: 768px) {
			.card.radius-15 {
				min-height: auto;
			}

			.bg-login-color {
				display: none;
			}

			.col-xl-6 {
				width: 100%;
			}

			.card-body {
				padding: 1.5rem;
			}

			.welcome-message {
				font-size: 1.5rem;
			}

			.card-body h3 {
				font-size: 1.2rem;
				margin-bottom: 1.5rem;
			}

			.form-body {
				max-width: 100%;
			}
		}
	</style>
</head>

<body class="bg-login">
	<!-- 3D Background Canvas -->
	<canvas id="three-canvas"></canvas>
	<!-- wrapper -->
	<div class="wrapper">
		<div class="section-authentication-login d-flex align-items-center justify-content-center">
			<div class="row">
				<div class="col-12 col-lg-10 mx-auto">
					<div class="card radius-15 overflow-hidden">
						<div class="row g-0">
							<div class="col-xl-6">
								<div class="card-body">
									<div class="text-center mb-4">
										<img src="assets/images/logo-icon.png" width="80" alt="">
										<h4 class="welcome-message">Selamat Datang di Sistem Informasi Manajemen Gudang
										</h4>
										<h3 class="font-weight-bold"><?= lang('Auth.loginTitle') ?></h3>
									</div>
									<div class="form-body">
										<?= view('Auth/_message_block') ?>
										<form class="row g-3" action="<?= url_to('login') ?>" method="post">
											<?= csrf_field() ?>
											<?php if ($config->validFields === ['email']): ?>
												<div class="col-12">
													<label for="login" class="form-label"><?= lang('Auth.email') ?></label>
													<input type="email"
														class="form-control <?php if (session('errors.login')): ?>is-invalid<?php endif ?>"
														id="login" name="login" placeholder="<?= lang('Auth.email') ?>">
													<div class="invalid-feedback">
														<?= session('errors.login') ?>
													</div>
												</div>
											<?php else: ?>
												<div class="col-12">
													<label for="login"
														class="form-label"><?= lang('Auth.emailOrUsername') ?></label>
													<input type="text"
														class="form-control <?php if (session('errors.login')): ?>is-invalid<?php endif ?>"
														id="login" name="login"
														placeholder="<?= lang('Auth.emailOrUsername') ?>">
													<div class="invalid-feedback">
														<?= session('errors.login') ?>
													</div>
												</div>
											<?php endif; ?>
											<div class="col-12">
												<label for="inputChoosePassword"
													class="form-label"><?= lang('Auth.password') ?></label>
												<div class="input-group" id="show_hide_password">
													<input type="password"
														class="form-control border-end-0 <?php if (session('errors.password')): ?>is-invalid<?php endif ?>"
														id="inputChoosePassword" name="password"
														placeholder="<?= lang('Auth.password') ?>">
													<a href="javascript:;" class="input-group-text bg-transparent"><i
															class="bx bx-hide"></i></a>
													<div class="invalid-feedback">
														<?= session('errors.password') ?>
													</div>
												</div>
											</div>
											<?php if ($config->allowRemembering): ?>
												<div class="col-12">
													<div class="form-check form-switch">
														<input class="form-check-input" type="checkbox"
															id="flexSwitchCheckChecked" name="remember" <?php if (old('remember')): ?> checked <?php endif ?>>
														<label class="form-check-label"
															for="flexSwitchCheckChecked"><?= lang('Auth.rememberMe') ?></label>
													</div>
												</div>
											<?php endif; ?>
											<div class="col-12">
												<div class="d-grid gap-3">
													<button type="submit" class="btn btn-primary"><i
															class="bx bxs-lock-open me-2"></i><?= lang('Auth.loginAction') ?></button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
							<div class="col-xl-6 bg-login-color d-flex align-items-center justify-content-center">
								<img src="assets/images/login-images/login-frent-img.jpg" class="img-fluid"
									alt="Sistem Informasi Manajemen Gudang">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end wrapper -->
	<!--plugins-->
	<script src="assets/js/jquery.min.js"></script>
	<!--Password show & hide js -->
	<script>
		$(document).ready(function () {
			$("#show_hide_password a").on('click', function (event) {
				event.preventDefault();
				if ($('#show_hide_password input').attr("type") == "text") {
					$('#show_hide_password input').attr('type', 'password');
					$('#show_hide_password i').addClass("bx-hide");
					$('#show_hide_password i').removeClass("bx-show");
				} else if ($('#show_hide_password input').attr("type") == "password") {
					$('#show_hide_password input').attr('type', 'text');
					$('#show_hide_password i').removeClass("bx-hide");
					$('#show_hide_password i').addClass("bx-show");
				}
			});
		});
	</script>
	<!-- Three.js 3D Background Script -->
	<script>
		// Initialize Three.js scene
		const scene = new THREE.Scene();
		const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
		const renderer = new THREE.WebGLRenderer({ canvas: document.getElementById('three-canvas'), alpha: true });
		renderer.setSize(window.innerWidth, window.innerHeight);

		// Create particle system
		const particlesGeometry = new THREE.BufferGeometry();
		const particleCount = 1000;
		const posArray = new Float32Array(particleCount * 3);
		for (let i = 0; i < particleCount * 3; i++) {
			posArray[i] = (Math.random() - 0.5) * 200; // Random positions
		}
		particlesGeometry.setAttribute('position', new THREE.BufferAttribute(posArray, 3));
		const particlesMaterial = new THREE.PointsMaterial({
			size: 0.5,
			color: 0x2a5298,
			transparent: true,
			opacity: 0.6
		});
		const particlesMesh = new THREE.Points(particlesGeometry, particlesMaterial);
		scene.add(particlesMesh);

		camera.position.z = 50;

		// Animation loop
		function animate() {
			requestAnimationFrame(animate);
			particlesMesh.rotation.y += 0.002; // Subtle rotation
			renderer.render(scene, camera);
		}
		animate();

		// Handle window resize
		window.addEventListener('resize', () => {
			camera.aspect = window.innerWidth / window.innerHeight;
			camera.updateProjectionMatrix();
			renderer.setSize(window.innerWidth, window.innerHeight);
		});
	</script>
</body>

</html>

<?php echo $this->endSection() ?>
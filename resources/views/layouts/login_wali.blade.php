
<!DOCTYPE html>
<html>
<head>
	<title>{{ config('app.name') }} | Login</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/styleLogin.css') }}">
</head>
<body>
	<img class="wave" src="{{ asset('Loginform') }}/img/wave.png">
	<div class="container">
		<div class="img">
			<img src="img/bg.svg">
		</div>
		<div class="login-content">
            <form method="POST" action="{{ route('login') }}">
                @csrf
				<img src="{{ asset('Loginform') }}/img/avatar.svg">
				<h2 class="title">Wali Murid</h2>
           		<div class="input-div one">
           		   <div class="i">
           		   		<i class="fas fa-user"></i>
           		   </div>
           		   <div class="div">
           		   		<h5>Email</h5>
           		   		<input id="email" type="email" class="input  @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
           		   </div>
           		</div>
           		<div class="input-div pass">
           		   <div class="i">
           		    	<i class="fas fa-lock"></i>
           		   </div>
           		   <div class="div">
           		    	<h5>Password</h5>
           		    	<input id="password" type="password" class="input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        @error('password')
                           <span class="invalid-feedback" role="alert">
                               <strong>{{ $message }}</strong>
                           </span>
                       @enderror
            	   </div>
            	</div>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif
            	{{-- <input type="submit" class="btn" value="Login"> --}}
                <button type="submit" class="btn">
                    {{ __('Login') }}
                </button>
            </form>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('Loginform') }}/js/main.js"></script>
</body>
</html>

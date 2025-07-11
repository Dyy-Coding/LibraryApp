<!-- resources/views/auth/login.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Load compiled Tailwind CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
</head>
<body class="min-h-screen bg-gray-100 text-gray-900 flex justify-center items-center">
    <div class="max-w-screen-xl bg-white shadow sm:rounded-lg flex w-full max-w-4xl">
        <!-- Login Form Section -->
        <div class="lg:w-1/2 xl:w-5/12 p-6 sm:p-12">
            <div class="flex justify-center">
                <img src="https://drive.google.com/uc?export=view&id=1MFiKAExRFF0-2YNpAZzIu1Sh52J8r16v" class="w-32" alt="Logo" />
            </div>

            <div class="mt-12 flex flex-col items-center">
                <div class="w-full mt-8">
                    <!-- Google Button -->
                    <div class="flex flex-col items-center">
                        <button
                            class="w-full max-w-xs font-bold shadow-sm rounded-lg py-3 bg-green-100 text-gray-800 flex items-center justify-center hover:shadow transition">
                            <div class="bg-white p-2 rounded-full">
                                <svg class="w-4" viewBox="0 0 533.5 544.3">
                                    <path fill="#4285f4" d="M533.5 278.4c0-18.5..."/>
                                    <path fill="#34a853" d="M272.1 544.3c73.4 0..."/>
                                    <path fill="#fbbc04" d="M119.3 324.3c-11.4..."/>
                                    <path fill="#ea4335" d="M272.1 107.7c38.8..."/>
                                </svg>
                            </div>
                            <span class="ml-4">Sign In with Google</span>
                        </button>
                    </div>

                    <div class="my-12 border-b text-center">
                        <span class="px-2 text-sm text-gray-600 bg-white">
                            Or sign in with your email
                        </span>
                    </div>

                    <!-- Login Form -->
                    <form method="POST" action="{{ route('login') }}" class="mx-auto max-w-xs">
                        @csrf

                        <!-- Email -->
                        <input
                            class="w-full px-8 py-4 rounded-lg bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white"
                            type="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus />

                        <!-- Password -->
                        <input
                            class="w-full px-8 py-4 rounded-lg bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white mt-5"
                            type="password" name="password" placeholder="Password" required />

                        <!-- Submit -->
                        <button
                            type="submit"
                            class="mt-5 font-semibold bg-green-500 text-white w-full py-4 rounded-lg hover:bg-green-700 transition flex items-center justify-center">
                            <svg class="w-6 h-6 -ml-2 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                                <circle cx="8.5" cy="7" r="4" />
                                <path d="M20 8v6M23 11h-6" />
                            </svg>
                            Sign In
                        </button>

                        <!-- Terms -->
                        <p class="mt-6 text-xs text-gray-600 text-center">
                            I agree to the
                            <a href="#" class="border-b border-gray-500">Terms of Service</a>
                            and
                            <a href="#" class="border-b border-gray-500">Privacy Policy</a>.
                        </p>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Image Section -->
        <div class="hidden lg:flex flex-1 bg-green-100 items-center justify-center">
            <div class="m-12 xl:m-16 w-full bg-contain bg-center bg-no-repeat"
                 style="background-image: url('https://drive.google.com/uc?export=view&id=1KZ_Ub_2lZ0dHbKV0fAIhxVhiQA183RCz');">
            </div>
        </div>
    </div>
</body>
</html>

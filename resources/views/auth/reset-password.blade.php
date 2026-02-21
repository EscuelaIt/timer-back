<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-md">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Reset Password</h2>
            
            <form id="resetForm" class="space-y-4">
                <input type="hidden" id="token" value="{{ $token }}">
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="your@email.com">
                    <span class="error text-red-500 text-sm mt-1 hidden"></span>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                    <input type="password" id="password" name="password" required minlength="8" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="At least 8 characters">
                    <span class="error text-red-500 text-sm mt-1 hidden"></span>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required minlength="8" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Confirm password">
                    <span class="error text-red-500 text-sm mt-1 hidden"></span>
                </div>

                <button type="submit" class="w-full bg-blue-500 text-white font-semibold py-2 rounded-lg hover:bg-blue-600 transition">
                    Reset Password
                </button>
            </form>

            <div id="successMessage" class="mt-4 p-4 bg-green-100 text-green-700 rounded-lg hidden text-center">
                Password reset successfully!
            </div>

            <div id="errorMessage" class="mt-4 p-4 bg-red-100 text-red-700 rounded-lg hidden text-center"></div>
        </div>
    </div>

    <script>
        document.getElementById('resetForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            const token = document.getElementById('token').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const password_confirmation = document.getElementById('password_confirmation').value;

            const errorMessage = document.getElementById('errorMessage');
            const successMessage = document.getElementById('successMessage');

            errorMessage.classList.add('hidden');
            successMessage.classList.add('hidden');

            try {
                const response = await fetch('/api/auth/reset-password', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        email,
                        token,
                        password,
                        password_confirmation
                    })
                });

                const data = await response.json();

                if (response.ok) {
                    successMessage.textContent = data.message;
                    successMessage.classList.remove('hidden');
                    document.getElementById('resetForm').reset();
                } else {
                    if (data.errors) {
                        let errorText = data.message + '\n';
                        Object.entries(data.errors).forEach(([field, messages]) => {
                            errorText += messages.join(', ') + '\n';
                        });
                        errorMessage.textContent = errorText;
                    } else {
                        errorMessage.textContent = data.message;
                    }
                    errorMessage.classList.remove('hidden');
                }
            } catch (error) {
                errorMessage.textContent = 'An error occurred. Please try again.';
                errorMessage.classList.remove('hidden');
            }
        });
    </script>
</body>
</html>

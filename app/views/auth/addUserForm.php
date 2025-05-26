<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Client</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<button class="mobile-toggle" id="toggleSidebar"><i class="bi bi-list"></i></button>
<body class="bg-gray-100">

<?php include __DIR__ . '/../partials/layout.html'; ?>

<div id="content" class="container mx-30 flex justify-center  min-h-screen">
    <div class="w-full max-w-6xl">
        <h1 class="text-3xl font-bold text-center mb-5">Ajouter gestionnaire</h1>
        <form method="POST" class="bg-white p-6 rounded shadow-md" action="/ABS-ISTA/createUser">
    
            <div class="mb-4">
                <label for="username" class="block text-gray-700">Username</label>
                <input type="text" id="username" name="username" class="w-full px-4 py-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label for="role" class="block text-gray-700">Role</label>
                <select id="role" name="role" class="w-full px-4 py-2 border rounded" required>
                    <option value="gestionnaire">Gestionnaire</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" id="pass" name="password" class="w-full px-4 py-2 border rounded" required>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Ajouter</button>
        </form>
    </div>
</div>
</body>
</html>

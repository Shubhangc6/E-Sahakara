<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Customer Service Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <style>
        body {
            display: flex; /* Use flexbox for layout */
            margin: 0; /* Remove default margin */
            height: 100vh; /* Full height of the viewport */
        }

        .sidebar {
            width: 250px; /* Fixed width for the sidebar */
            background-color: #fff; /* Background color for the sidebar */
            height: 100%; /* Full height */
            position: fixed; /* Fixed position */
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1); /* Optional shadow */
            overflow-y: auto; /* Allow scrolling if content overflows */
        }

        .main-content {
            margin-left: 250px; /* Margin to accommodate the sidebar */
            padding: 20px; /* Padding for the main content */
            flex-grow: 1; /* Allow main content to grow */
        }

        .table-fixed {
            width: 100%; /* Full width */
            max-width: 800px; /* Set a maximum width for the table */
            table-layout: fixed; /* Fixed layout for the table */
        }

        .table-fixed th, .table-fixed td {
            overflow: hidden; /* Hide overflow */
            text-overflow: ellipsis; /* Show ellipsis for overflow text */
            white-space: nowrap; /* Prevent text from wrapping */
        }

        /* Modal styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1000; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="sidebar">
        <div class="flex items-center justify-center mb-8">
            <img alt="E-Sahakara Logo" class="h-16 w-16" src="logo.png" width="100" height="100" />
        </div>
        <nav>
            <ul>
                <li class="mb-4">
                    <a class="flex items-center text-gray-700 hover:text-orange-500" href="customer.php"><i class="fas fa-home mr-3"></i> Home</a>
                </li>
                <li class="mb-4">
                    <a class="flex items-center text-gray-700 hover:text-orange-500" href="login.html"><i class="fas fa-sign-out-alt mr-3"></i> Logout</a>
                </li>
            </ul>
        </nav>
    </div>
    <div class="main-content">
        <header class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-700">Customer Service Portal</h1>
            <div class="flex items-center space-x-4">
                <span class="text-gray-700">Welcome</span>
                <img alt="User  Avatar" class="h-10 w-10 rounded-full cursor-pointer" src="user.jpg" width="100" height="100" />
            </div>
        </header>

        <!-- Service Request Form -->
        <div id="requestFormContainer" class="bg-white p-6 rounded-lg shadow-lg mb-6 hidden">
            <h4 class="mb-4">Submit a Service Request</h4>
            <form onsubmit="addRequest(event)">
                <div class="mb-4">
                    <label for="issueType" class="block text-gray-700">Select Issue Type:</label>
                    <select class="w-full px-3 py-2 border border-gray-300 rounded" id="issueType" required>
                        <option value="">---Select option---</option>
                        <option value="Account Issue">Account Issue</option>
                        <option value="Transaction Issue">Transaction Issue</option>
                        <option value="Loan Inquiry">Loan Inquiry</option>
                        <option value="Card Block/Unblock">Card Block/Unblock</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="message" class="block text-gray-700">Issue Details:</label>
                    <textarea class="w-full px-3 py-2 border border-gray-300 rounded" id="message" rows="3" placeholder="Describe your issue" required></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded">Submit Request</button>
                </div>
            </form>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
            <h4 class="mb-4">Your Complaints</h4>
            <table class="min-w-full bg-white border border-gray-300 table-fixed">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Issue Type</th>
                        <th class="py-2 px-4 border-b">Message</th>
                        <th class="py-2 px-4 border-b">Admin Response</th>
                        <th class="py-2 px-4 border-b">Customer Response</th>
                        <th class="py-2 px-4 border-b">Status</th>
                    </tr>
                </thead>
                <tbody id="customerRequests"></tbody>
            </table>
        </div>

        <!-- Request Details Modal -->
        <div id="requestDetailsModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <div id="requestDetailsContent"></div>
                <button class="close bg-red-500 text-white px-4 py-2 rounded mt-4" onclick="closeModal()">Close</button>
            </div>
        </div>

        <!-- Chatbot Section -->
        <div id="chatbot" class="bg-white p-6 rounded-lg shadow-lg mb-6">
            <h4 class="mb-4">Chatbot Support</h4>
            <div id="chatWindow" class="border border-gray-300 h-64 overflow-y-auto p-4 mb-4">
              <!-- Chat messages will be displayed here -->
            </div>
            <input type="text" id="userInput" class="border border-gray-300 rounded w-full px-3 py-2" placeholder="Type your query..." autocomplete="off" />
            <button id="sendButton" class="bg-orange-500 text-white px-4 py-2 rounded mt-2">Send</button>
        </div>
    </div>

    <script>
        const userId = <?php echo json_encode($_SESSION['user_id']); ?>; // Get the logged-in user ID
        let requestPermissionGranted = false;
        let commonQuestions = {};

        // Fetch common questions from the backend
        function fetchCommonQuestions() {
            fetch('fetch_common_questions.php')
                .then(response => response.json())
                .then(data => {
                    commonQuestions = data; // Store the common questions in a variable
                })
                .catch(error => {
                    console.error('Error fetching common questions:', error);
                });
        }

        function fetchCustomerRequests() {
            fetch('fetch_requests.php?customerId=' + userId)
                .then((response) => response.json())
                .then((data) => {
                    if (data.error) {
                        console.error('Error fetching requests:', data.error);
                        return;
                    }
                    displayCustomerRequests(data);
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        }

        function displayCustomerRequests(requests) {
            const requestTableBody = document.getElementById('customerRequests');
            requestTableBody.innerHTML = ''; // Clear existing content

            requests.forEach((request) => {
                const statusColor = request.status === 'RESOLVED' ? 'bg-green-500' : 'bg-orange-500';
                requestTableBody.innerHTML += `
                    <tr>
                        <td class="py-2 px-4 border-b text-center align-middle">${request.issue_type}</td>
                        <td class="py-2 px-4 border-b text-center align-middle truncate-message" onclick="showRequestDetails(${request.id})">${request.message}</td>
                        <td class="py-2 px-4 border-b text-center align-middle truncate-message" onclick="showRequestDetails(${request.id})">${request.admin_response || 'No response yet'}</td>
                        <td class="py-2 px-4 border-b text-center align-middle">
                            <button class="bg-green-500 text-white px-2 py-1 rounded" onclick="submitResponse(${request.id}, '👍')">👍</button>
                            <button class="bg-red-500 text-white px-2 py-1 rounded" onclick="submitResponse(${request.id}, '👎')">👎</button>
                        </td>
                        <td class="py-2 px-4 border-b text-center align-middle">
                            <button class="${statusColor} text-white px-3 py-1 rounded">${request.status || 'Pending'}</button>
                        </td>
                    </tr>
                `;
            });
        }

        function showRequestDetails(requestId) {
            fetch(`fetch_request_details.php?id=${requestId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        console.error('Error fetching request details:', data.error);
                        return;
                    }
                    // Populate the details modal content
                    document.getElementById('requestDetailsContent').innerHTML = `
                        <h3 class="text-lg font-bold mb-4">Request Details</h3>
                        <p><strong>Customer ID:</strong> ${data.customer_id}</p>
                        <p><strong>Customer Email:</strong> ${data.customer_email}</p>
                        <p><strong>Issue Type:</strong> ${data.issue_type}</p>
                        <p><strong>Message:</strong> ${data.message}</p>
                        <p><strong>Admin Response:</strong> ${data.admin_response || 'No response yet'}</p>
                        <p><strong>Status:</strong> ${data.status}</p>
                    `;
                    // Show modal
                    document.getElementById('requestDetailsModal').style.display = "block";
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function closeModal() {
            document.getElementById('requestDetailsModal').style.display = "none";
        }

        function submitResponse(requestId, response) {
            fetch('submit_customer_response.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ requestId, response }),
            })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    alert('Response submitted successfully!');
                    fetchCustomerRequests(); // Refresh the displayed requests
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        }

        function addRequest(event) {
            event.preventDefault();
            const issueType = document.getElementById('issueType').value;
            const message = document.getElementById('message').value;

            fetch('submit_request.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ customerId: userId, issueType, message }),
            })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    alert('Request submitted successfully!');
                    fetchCustomerRequests(); // Refresh the displayed requests
                    hideRequestForm(); // Hide the request form after submission
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        }

        // Chatbot functionality
        document.getElementById('sendButton').addEventListener('click', () => {
            const userInput = document.getElementById('userInput').value;
            if (userInput.trim() === '') return;

            // Display user message
            displayMessage('You: ' + userInput);
            document.getElementById('userInput').value = ''; // Clear input

            // Handle the query
            handleQuery(userInput);
        });

        // Allow Enter key to send message
        document
            .getElementById('userInput')
            .addEventListener('keypress', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    document.getElementById('sendButton').click();
                }
            });

        function handleQuery(query) {
            const lowerCaseQuery = query.toLowerCase().trim();
            let response = '';

            // Check if the query matches any common questions
            for (const [question, answer] of Object.entries(commonQuestions)) {
                if (lowerCaseQuery.includes(question.toLowerCase())) {
                    response = answer;
                    break;
                }
            }

            // If no match found, provide a default response and show the request form
            if (!response) {
                response = "I'm sorry, I couldn't resolve your request. Would you like to submit a service request?";
                displayMessage('Chatbot: ' + response);
                showRequestForm(); // Show the request form
            } else {
                displayMessage('Chatbot: ' + response);
            }
        }

        function displayMessage(message) {
            const chatWindow = document.getElementById('chatWindow');
            chatWindow.innerHTML += `<div class="mb-2">${message}</div>`;
            chatWindow.scrollTop = chatWindow.scrollHeight; // Scroll to the bottom
        }

        function showRequestForm() {
            document.getElementById('requestFormContainer').classList.remove('hidden');
        }

        function hideRequestForm() {
            document.getElementById('requestFormContainer').classList.add('hidden');
        }

        // Fetch common questions on page load
        document.addEventListener('DOMContentLoaded', () => {
            fetchCustomerRequests();
            fetchCommonQuestions(); // Fetch common questions
            hideRequestForm();
        });
    </script>
</body>
</html>

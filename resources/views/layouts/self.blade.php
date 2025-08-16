<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
        }

        .dark {
            background-color: #1a202c;
            color: #e2e8f0;
        }

        .dark .bg-white {
            background-color: #2d3748;
        }

        .dark .text-gray-700,
        .dark .text-gray-800 {
            color: #e2e8f0;
        }

        .dark input,
        .dark textarea {
            background-color: #4a5568;
            color: #e2e8f0;
            border-color: #718096;
        }

        .transition-bg {
            transition: background-color 0.3s ease, color 0.3s ease;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex">
        @include('partials.sidebar')
        <main class="flex-1 overflow-x-hidden overflow-y-auto  bg-gray-800 border">
            @yield('content')
        </main>
    </div>

    <script>
        // Dark mode toggle
        const darkModeToggle = document.getElementById('darkModeToggle');
        const body = document.body;
        const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)');

        // function setDarkMode(isDark) {
        //     body.classList.toggle('dark', isDark);
        //     darkModeToggle.innerHTML = isDark ? '<i class="fas fa-sun"></i>' : '<i class="fas fa-moon"></i>';
        //     localStorage.setItem('darkMode', isDark ? 'enabled' : 'disabled');
        // }

        // Check for saved user preference, if any, on load
        // const darkModeStorage = localStorage.getItem('darkMode');

        // if (darkModeStorage === 'enabled') {
        //     setDarkMode(true);
        // } else if (darkModeStorage === 'disabled') {
        //     setDarkMode(false);
        // } else {
        //     setDarkMode(prefersDarkScheme.matches);
        // }

        // Add toggle event listener
        // darkModeToggle.addEventListener('click', () => {
        //     setDarkMode(!body.classList.contains('dark'));
        // });

        // Listen for changes to the user's preferred color scheme
        prefersDarkScheme.addListener((evt) => {
            setDarkMode(evt.matches);
        });

        // Admin form submission
        const adminForm = document.getElementById('adminForm');
        adminForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(adminForm);
            const adminData = Object.fromEntries(formData.entries());
            console.log('Admin data submitted:', adminData);
            
            // Validate password match
            if (adminData.password !== adminData['confirm-password']) {
                alert('Passwords do not match. Please try again.');
                return;
            }
            
            // Here you would typically send the data to your backend
            // For now, we'll just show an alert
            alert('Admin details updated successfully!');
        });

        // Generate sales report
        const generateReportBtn = document.getElementById('generateReport');
        generateReportBtn.addEventListener('click', () => {
            // Sample sales data
            const salesData = [
                { date: '2023-01-01', product: 'Widget A', quantity: 10, revenue: 1000 },
                { date: '2023-01-02', product: 'Widget B', quantity: 5, revenue: 750 },
                { date: '2023-01-03', product: 'Widget C', quantity: 8, revenue: 1200 },
                { date: '2023-01-04', product: 'Widget A', quantity: 15, revenue: 1500 },
                { date: '2023-01-05', product: 'Widget B', quantity: 7, revenue: 1050 },
            ];

            // Create workbook and worksheet
            const wb = XLSX.utils.book_new();
            const ws = XLSX.utils.json_to_sheet(salesData);

            // Add worksheet to workbook
            XLSX.utils.book_append_sheet(wb, ws, 'Sales Report');

            // Generate Excel file
            XLSX.writeFile(wb, 'sales_report.xlsx');

            alert('Sales report generated successfully!');
        });
    </script>
    
</body>
</html>
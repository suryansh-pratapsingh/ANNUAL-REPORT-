<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Help & Support - Annual Vision</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
    body {
        background: #111;
        color: white;
    }
    .background {
        position: fixed;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg, rgba(0, 255, 255, 0.2), rgba(255, 0, 150, 0.2));
        animation: moveBackground 10s linear infinite;
        z-index: -1;
    }
    @keyframes moveBackground {
        from { transform: translate(-50%, -50%) rotate(0deg); }
        to { transform: translate(-50%, -50%) rotate(360deg); }
    }
    .card, .navbar { background-color: #222; }
    .card-title { color: #00cccc; }
    .faq-section { background-color: #333; color: #ddd; border-radius: 8px; }
    .accordion-button { background-color: #444; color: #fff; }
    .accordion-button:not(.collapsed) {
        background: linear-gradient(45deg, #00cccc, #007b7b);
        color: #fff;
    }
    .accordion-body { background-color: #222; color: #ddd; }
    .footer { margin-top: 20px; padding: 10px 0; background-color: #222; color: #ddd; text-align: center; }
    </style>
</head>

<body>
    <div class="background"></div>

    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">
                <img src="l.png" alt="Logo" width="30" height="30" class="d-inline-block align-top">
                Annual Vision
            </a>
            <div>
                <a href="logout.php" class="btn btn-outline-light">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Help & Support Section -->
    <div class="container mt-5">
        <h2 class="text-center section-title">Help & Support</h2>
        
        <!-- Contact Details -->
        <div class="card p-4 shadow mt-3">
            <h5 class="card-title">Contact Support</h5>
            <p class="card-text">If you need assistance, please reach out to me:</p>
            <ul>
                <li>Email: suryanshpratap220573@acropolis.in</li>
                <li>Phone: +91 78699 99794</li>
            </ul>
        </div>
        
        <!-- FAQs -->
        <div class="card p-4 shadow mt-4 faq-section">
            <h5 class="card-title">Frequently Asked Questions</h5>
            <div class="accordion" id="faqAccordion">
                <?php
                $faqs = [
                    "How do I import data?" => "Navigate to the 'Data Import' page, upload the Excel file, and click 'Submit' to analyze.",
                    "What data format is required for import?" => "The file should be in Excel format, with columns for enrollment, name, subject-wise marks, attendance, and extracurricular activities.",
                    "How can I view generated reports?" => "Go to 'View All Reports' on the dashboard to see the reports for all classes.",
                    "Can I download the report as a PDF?" => "Yes, each report includes a 'Download as PDF' option for easy access.",
                    "How is the top 10 ranker list generated?" => "Rankings are calculated based on overall marks across all subjects for each student.",
                    "How can I visualize data through charts?" => "Charts are generated automatically in the report based on subject-wise and attendance data.",
                    "What if my data import fails?" => "Ensure the data format matches the template. Contact support if issues persist.",
                    "How do I log out of the application?" => "Click the 'Logout' button on the navbar to end your session securely.",
                    "Can I update student data after importing?" => "Currently, data editing is not supported. Re-import the file if corrections are needed.",
                    "Who can I contact for additional support?" => "You can reach out to Suryansh Pratap Singh at suryansh.singh@hotwax.co for any help."
                ];

                $index = 1;
                foreach ($faqs as $question => $answer) {
                    echo "
                    <div class='accordion-item'>
                        <h2 class='accordion-header' id='heading$index'>
                            <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#collapse$index' aria-expanded='false' aria-controls='collapse$index'>
                                $question
                            </button>
                        </h2>
                        <div id='collapse$index' class='accordion-collapse collapse' aria-labelledby='heading$index' data-bs-parent='#faqAccordion'>
                            <div class='accordion-body'>
                                $answer
                            </div>
                        </div>
                    </div>";
                    $index++;
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Developed by Suryansh Pratap Singh and Team under the guidance of Shushma Khatri Ma'am.</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

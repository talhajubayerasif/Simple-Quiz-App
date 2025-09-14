<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quiz_app";

// Create a new database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function insertQuestions($conn, $subjectTitle, $questions) {
    // Check if the quiz already exists to avoid duplicates
    $stmt = $conn->prepare("SELECT id FROM quizzes WHERE title = ?");
    $stmt->bind_param("s", $subjectTitle);
    $stmt->execute();
    $result = $stmt->get_result();
    $quizId = null;
    if ($result->num_rows > 0) {
        $quiz = $result->fetch_assoc();
        $quizId = $quiz['id'];
    } else {
        $stmt_insert_quiz = $conn->prepare("INSERT INTO quizzes (title) VALUES (?)");
        $stmt_insert_quiz->bind_param("s", $subjectTitle);
        $stmt_insert_quiz->execute();
        $quizId = $conn->insert_id;
        $stmt_insert_quiz->close();
    }
    $stmt->close();

    $stmt_insert_question = $conn->prepare("INSERT INTO questions (quiz_id, question_text, option_a, option_b, option_c, option_d, correct_option) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt_insert_question->bind_param("issssss", $quizId, $questionText, $optionA, $optionB, $optionC, $optionD, $correctOption);

    foreach ($questions as $q) {
        $questionText = $q['question'];
        $optionA = $q['options'][0];
        $optionB = $q['options'][1];
        $optionC = $q['options'][2];
        $optionD = $q['options'][3];
        $correctOption = $q['correct'];
        $stmt_insert_question->execute();
    }
    $stmt_insert_question->close();
    echo "Successfully inserted " . count($questions) . " questions for " . $subjectTitle . "<br>";
}

// ----------------------------------------------------
// CSE Questions
// ----------------------------------------------------
$cseQuestions = [
    // 40+ CSE Questions
    [
        'question' => 'What does PHP stand for?',
        'options' => ['Personal Home Page', 'Personal Hypertext Processor', 'PHP: Hypertext Preprocessor', 'Private Host Program'],
        'correct' => 'option_c'
    ],
    [
        'question' => 'Which of the following is not a data type in C?',
        'options' => ['int', 'float', 'char', 'string'],
        'correct' => 'option_d'
    ],
    [
        'question' => 'What does SQL stand for?',
        'options' => ['Structured Query Language', 'Simple Query Language', 'System Query Logic', 'Sequential Query Language'],
        'correct' => 'option_a'
    ],
    [
        'question' => 'What is the purpose of the `git clone` command?',
        'options' => ['To initialize a new repository', 'To create a copy of a remote repository', 'To merge branches', 'To commit changes'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'What does HTML stand for?',
        'options' => ['Hyperlinks and Text Markup Language', 'Hypertext Markup Language', 'Home Tool Markup Language', 'Hyper Tool Markup Language'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'Which CSS property controls the text size?',
        'options' => ['font-style', 'text-size', 'font-size', 'text-style'],
        'correct' => 'option_c'
    ],
    [
        'question' => 'What is a boolean?',
        'options' => ['A data type that stores text', 'A data type that stores only true or false values', 'A data type that stores numbers', 'A data type that stores dates'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'Which language is primarily used for web browser interactivity?',
        'options' => ['Java', 'C++', 'Python', 'JavaScript'],
        'correct' => 'option_d'
    ],
    [
        'question' => 'What is the standard port for HTTP?',
        'options' => ['21', '80', '443', '25'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'In object-oriented programming, what is a class?',
        'options' => ['A function', 'A blueprint for objects', 'A variable', 'A database table'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'What is a primary key in a database?',
        'options' => ['A key that unlocks the database', 'A unique identifier for a record', 'A key used for encryption', 'A key that links two tables'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'What does API stand for?',
        'options' => ['Application Programming Interface', 'Application Process Integration', 'Advanced Protocol Interface', 'Automated Program Integration'],
        'correct' => 'option_a'
    ],
    [
        'question' => 'Which protocol is used for email?',
        'options' => ['FTP', 'HTTP', 'SMTP', 'TCP'],
        'correct' => 'option_c'
    ],
    [
        'question' => 'What is the binary representation of the decimal number 10?',
        'options' => ['1010', '0101', '1000', '1100'],
        'correct' => 'option_a'
    ],
    [
        'question' => 'What is the output of `console.log(1 + "1")` in JavaScript?',
        'options' => ['2', '11', 'Error', 'undefined'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'Which of the following is a Linux command to list files?',
        'options' => ['dir', 'list', 'ls', 'show'],
        'correct' => 'option_c'
    ],
    [
        'question' => 'What does CPU stand for?',
        'options' => ['Central Process Unit', 'Central Processing Unit', 'Computer Personal Unit', 'Control Processing Unit'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'What is the purpose of `JOIN` in SQL?',
        'options' => ['To combine rows from two or more tables', 'To add a new column', 'To sort data', 'To delete a table'],
        'correct' => 'option_a'
    ],
    [
        'question' => 'Which data structure is LIFO?',
        'options' => ['Queue', 'Linked List', 'Stack', 'Array'],
        'correct' => 'option_c'
    ],
    [
        'question' => 'What does RAM stand for?',
        'options' => ['Random Access Memory', 'Read Access Memory', 'Run Access Memory', 'Rapid Access Memory'],
        'correct' => 'option_a'
    ],
    [
        'question' => 'Which programming language is a superset of JavaScript?',
        'options' => ['Java', 'TypeScript', 'C++', 'Python'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'What is the main purpose of a firewall?',
        'options' => ['To prevent viruses', 'To control network traffic', 'To speed up the internet', 'To store data'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'In web development, what is a "frontend"?',
        'options' => ['The part of the website the user sees and interacts with', 'The server-side code', 'The database', 'The network infrastructure'],
        'correct' => 'option_a'
    ],
    [
        'question' => 'What does URL stand for?',
        'options' => ['Universal Resource Locator', 'Uniform Resource Locator', 'Unique Resource Link', 'Uniform Reference Link'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'Which of the following is a version control system?',
        'options' => ['GitHub', 'Git', 'HTML', 'CSS'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'What is the purpose of a `for` loop?',
        'options' => ['To execute a block of code only once', 'To check a condition', 'To iterate over a sequence of elements', 'To create a new function'],
        'correct' => 'option_c'
    ],
    [
        'question' => 'What is the full form of LAN?',
        'options' => ['Local Area Network', 'Large Area Network', 'Long Access Network', 'Logical Area Network'],
        'correct' => 'option_a'
    ],
    [
        'question' => 'What is the main function of an operating system?',
        'options' => ['To provide hardware support', 'To manage computer hardware and software resources', 'To run a web server', 'To create documents'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'What is a compiler?',
        'options' => ['A program that translates source code into machine code', 'A program that runs other programs', 'A text editor', 'A debugger'],
        'correct' => 'option_a'
    ],
    [
        'question' => 'Which of these is a popular JavaScript library for building user interfaces?',
        'options' => ['Laravel', 'Django', 'React', 'Flask'],
        'correct' => 'option_c'
    ],
    [
        'question' => 'What is the purpose of a primary key in a database?',
        'options' => ['To uniquely identify each record in a table.', 'To sort the records in a table.', 'To establish a relationship between two tables.', 'To prevent duplicate records.'],
        'correct' => 'option_a'
    ],
    [
        'question' => 'Which protocol is used for secure communication over a computer network?',
        'options' => ['HTTP', 'FTP', 'HTTPS', 'SMTP'],
        'correct' => 'option_c'
    ],
    [
        'question' => 'What is the binary representation of the decimal number 5?',
        'options' => ['101', '010', '110', '100'],
        'correct' => 'option_a'
    ],
    [
        'question' => 'What is the main purpose of an HTML `DOCTYPE` declaration?',
        'options' => ['To link a stylesheet', 'To declare the document type to the browser', 'To define a new HTML element', 'To create a template'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'What is the main benefit of using a `while` loop over a `for` loop?',
        'options' => ['It is always faster', 'It is easier to read', 'It is best when the number of iterations is unknown.', 'It can handle more data types'],
        'correct' => 'option_c'
    ],
    [
        'question' => 'What is a subnet mask?',
        'options' => ['A tool for network security', 'A number that defines a network and host portion of an IP address', 'A type of network cable', 'A password for a network'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'What is the purpose of a CSS preprocessor like SASS?',
        'options' => ['To minify CSS files', 'To add features like variables and nesting to CSS', 'To run CSS on the server', 'To compile JavaScript'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'Which of the following is a relational database management system?',
        'options' => ['MongoDB', 'Redis', 'MySQL', 'Cassandra'],
        'correct' => 'option_c'
    ],
    [
        'question' => 'What is the purpose of a `try...catch` block?',
        'options' => ['To execute code multiple times', 'To handle errors gracefully', 'To define a new variable', 'To create a loop'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'What is the main function of a router?',
        'options' => ['To connect computers on a local network', 'To route data packets between different networks', 'To provide wireless internet', 'To store files'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'What is the time complexity of a binary search algorithm?',
        'options' => ['O(n)', 'O(n^2)', 'O(log n)', 'O(1)'],
        'correct' => 'option_c'
    ]
];

// ----------------------------------------------------
// Chemistry Questions
// ----------------------------------------------------
$chemistryQuestions = [
    // 40+ Chemistry Questions
    [
        'question' => 'What is the chemical symbol for gold?',
        'options' => ['Ag', 'Au', 'Fe', 'H'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'What is the pH of a neutral solution?',
        'options' => ['0', '7', '14', '1'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'Which gas is most abundant in Earth\'s atmosphere?',
        'options' => ['Oxygen', 'Hydrogen', 'Nitrogen', 'Carbon Dioxide'],
        'correct' => 'option_c'
    ],
    [
        'question' => 'What is the chemical formula for water?',
        'options' => ['H2O', 'CO2', 'NaCl', 'O2'],
        'correct' => 'option_a'
    ],
    [
        'question' => 'What element is essential for all life forms on Earth?',
        'options' => ['Helium', 'Carbon', 'Iron', 'Sodium'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'The process of a solid turning directly into a gas is called:',
        'options' => ['Melting', 'Evaporation', 'Sublimation', 'Condensation'],
        'correct' => 'option_c'
    ],
    [
        'question' => 'What is the charge of a proton?',
        'options' => ['Positive', 'Negative', 'Neutral', 'Depends on the atom'],
        'correct' => 'option_a'
    ],
    [
        'question' => 'Which of these is a noble gas?',
        'options' => ['Oxygen', 'Hydrogen', 'Helium', 'Nitrogen'],
        'correct' => 'option_c'
    ],
    [
        'question' => 'What is the SI unit of mass?',
        'options' => ['Pound', 'Kilogram', 'Gram', 'Ounce'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'What is the term for a substance that speeds up a chemical reaction without being consumed?',
        'options' => ['Inhibitor', 'Catalyst', 'Enzyme', 'Reactant'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'What is the chemical symbol for sodium?',
        'options' => ['Na', 'So', 'N', 'S'],
        'correct' => 'option_a'
    ],
    [
        'question' => 'What is the chemical formula for table salt?',
        'options' => ['KCl', 'H2SO4', 'NaCl', 'HCl'],
        'correct' => 'option_c'
    ],
    [
        'question' => 'What is the main component of natural gas?',
        'options' => ['Ethane', 'Propane', 'Butane', 'Methane'],
        'correct' => 'option_d'
    ],
    [
        'question' => 'What is the process of splitting an atom?',
        'options' => ['Fusion', 'Fission', 'Oxidation', 'Reduction'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'What is the heaviest naturally occurring element?',
        'options' => ['Plutonium', 'Uranium', 'Lead', 'Gold'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'What is the chemical symbol for silver?',
        'options' => ['Ag', 'Au', 'Sr', 'Si'],
        'correct' => 'option_a'
    ],
    [
        'question' => 'What is the formula for sulfuric acid?',
        'options' => ['HSO4', 'H2SO4', 'HCL', 'HNO3'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'Which metal is liquid at room temperature?',
        'options' => ['Iron', 'Lead', 'Mercury', 'Tin'],
        'correct' => 'option_c'
    ],
    [
        'question' => 'What is the smallest unit of an element?',
        'options' => ['Molecule', 'Atom', 'Proton', 'Electron'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'What is the charge of a neutron?',
        'options' => ['Positive', 'Negative', 'Neutral', 'None of the above'],
        'correct' => 'option_c'
    ],
    [
        'question' => 'Which of the following is a halogen?',
        'options' => ['Helium', 'Fluorine', 'Neon', 'Argon'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'What is the process of a liquid turning into a gas?',
        'options' => ['Condensation', 'Evaporation', 'Sublimation', 'Melting'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'What is the primary component of glass?',
        'options' => ['Calcium carbonate', 'Sodium chloride', 'Silicon dioxide', 'Aluminum oxide'],
        'correct' => 'option_c'
    ],
    [
        'question' => 'Which of these is a strong acid?',
        'options' => ['Acetic Acid', 'Citric Acid', 'Hydrochloric Acid', 'Carbonic Acid'],
        'correct' => 'option_c'
    ],
    [
        'question' => 'What is the atomic number of oxygen?',
        'options' => ['6', '7', '8', '9'],
        'correct' => 'option_c'
    ],
    [
        'question' => 'What is the chemical formula for rust?',
        'options' => ['Fe2O3', 'FeO', 'Fe3O4', 'FeOH'],
        'correct' => 'option_a'
    ],
    [
        'question' => 'Which acid is found in vinegar?',
        'options' => ['Sulfuric acid', 'Acetic acid', 'Nitric acid', 'Citric acid'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'What is the symbol for potassium?',
        'options' => ['P', 'K', 'Po', 'Pt'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'What is the common name for dihydrogen monoxide?',
        'options' => ['Salt', 'Sugar', 'Water', 'Ammonia'],
        'correct' => 'option_c'
    ],
    [
        'question' => 'What is the process of a gas turning into a liquid?',
        'options' => ['Evaporation', 'Sublimation', 'Condensation', 'Melting'],
        'correct' => 'option_c'
    ],
    [
        'question' => 'What is the term for a mixture where substances are not uniformly distributed?',
        'options' => ['Homogeneous mixture', 'Heterogeneous mixture', 'Solution', 'Suspension'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'What is the chemical formula for carbon dioxide?',
        'options' => ['CO', 'C2O', 'CO2', 'CO3'],
        'correct' => 'option_c'
    ],
    [
        'question' => 'What is the chemical symbol for lead?',
        'options' => ['Pb', 'Ld', 'Fe', 'Pt'],
        'correct' => 'option_a'
    ],
    [
        'question' => 'What is an ion?',
        'options' => ['A neutral atom', 'A charged atom or molecule', 'An atom with no electrons', 'An atom with no protons'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'What is the purpose of an indicator in a titration?',
        'options' => ['To speed up the reaction', 'To change color at the endpoint', 'To increase the volume', 'To absorb heat'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'Which element is a key component of organic chemistry?',
        'options' => ['Oxygen', 'Hydrogen', 'Nitrogen', 'Carbon'],
        'correct' => 'option_d'
    ],
    [
        'question' => 'What is the chemical formula for baking soda?',
        'options' => ['NaOH', 'NaCl', 'NaHCO3', 'CaCO3'],
        'correct' => 'option_c'
    ],
    [
        'question' => 'What type of bond holds sodium and chloride atoms together in salt?',
        'options' => ['Covalent', 'Ionic', 'Metallic', 'Hydrogen'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'What is the main component of the air we breathe?',
        'options' => ['Oxygen', 'Nitrogen', 'Carbon dioxide', 'Argon'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'Which of the following is an allotrope of carbon?',
        'options' => ['Graphite', 'Quartz', 'Diamond', 'Both a and c'],
        'correct' => 'option_d'
    ]
];

// ----------------------------------------------------
// History of Bangladesh Questions
// ----------------------------------------------------
$historyQuestions = [
    // 40+ History of Bangladesh Questions
    [
        'question' => 'When did Bangladesh gain independence?',
        'options' => ['December 16, 1971', 'March 26, 1971', 'January 26, 1972', 'December 10, 1970'],
        'correct' => 'option_a'
    ],
    [
        'question' => 'Who is considered the Father of the Nation of Bangladesh?',
        'options' => ['Ziaur Rahman', 'Sheikh Mujibur Rahman', 'Ayub Khan', 'Maulana Bhashani'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'What was the official name of the liberation war of Bangladesh?',
        'options' => ['Operation Searchlight', 'The Bangladesh Liberation War', 'The Indo-Pakistani War of 1971', 'The Great War'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'What was the capital of East Pakistan?',
        'options' => ['Karachi', 'Lahore', 'Dhaka', 'Chittagong'],
        'correct' => 'option_c'
    ],
    [
        'question' => 'Who was the first President of Bangladesh?',
        'options' => ['Sheikh Mujibur Rahman', 'Ziaur Rahman', 'Syed Nazrul Islam', 'Tajuddin Ahmad'],
        'correct' => 'option_a'
    ],
    [
        'question' => 'What is the name of the national anthem of Bangladesh?',
        'options' => ['Jana Gana Mana', 'Amar Sonar Bangla', 'Shonar Bangla', 'Shadhinota'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'What was the main cause of the Language Movement in 1952?',
        'options' => ['Economic disparity', 'Political oppression', 'The declaration of Urdu as the state language', 'Religious conflict'],
        'correct' => 'option_c'
    ],
    [
        'question' => 'Which battle ended the rule of the Nawab of Bengal and led to British rule?',
        'options' => ['Battle of Panipat', 'Battle of Plassey', 'Battle of Buxar', 'Battle of Haldighati'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'Who was the first Prime Minister of Bangladesh?',
        'options' => ['Sheikh Mujibur Rahman', 'Tajuddin Ahmad', 'Ziaur Rahman', 'Muhammad Mansur Ali'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'What is the significance of March 7, 1971?',
        'options' => ['Declaration of Independence', 'The start of the Liberation War', 'Sheikh Mujib\'s historic speech', 'Signing of the Instrument of Surrender'],
        'correct' => 'option_c'
    ],
    [
        'question' => 'What was the name of the military operation launched by the Pakistan Army on March 25, 1971?',
        'options' => ['Operation Jackpot', 'Operation Searchlight', 'Operation Eagle', 'Operation Clean Sweep'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'When was the Instrument of Surrender signed?',
        'options' => ['March 26, 1971', 'April 17, 1971', 'December 16, 1971', 'January 10, 1972'],
        'correct' => 'option_c'
    ],
    [
        'question' => 'Who was the commander-in-chief of the Bangladesh Armed Forces during the Liberation War?',
        'options' => ['General M. A. G. Osmani', 'General Ziaur Rahman', 'General H. M. Ershad', 'General Shafiul Azam'],
        'correct' => 'option_a'
    ],
    [
        'question' => 'Which sector of the Liberation War was responsible for naval operations?',
        'options' => ['Sector 1', 'Sector 10', 'Sector 11', 'Sector 5'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'Who was the first woman to become a minister in Bangladesh?',
        'options' => ['Khaleda Zia', 'Sheikh Hasina', 'Sajeda Chowdhury', 'Sultana Ahmed'],
        'correct' => 'option_c'
    ],
    [
        'question' => 'What was the name of the government formed by the Bengali leaders in exile during the Liberation War?',
        'options' => ['Provisional Government of Bangladesh', 'Mujibnagar Government', 'Bangladesh Government in Exile', 'Both a and b'],
        'correct' => 'option_d'
    ],
    [
        'question' => 'The Six-Point Movement was a political movement in East Pakistan advocating for:',
        'options' => ['Economic equality', 'Greater autonomy for East Pakistan', 'Religious freedom', 'Universal suffrage'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'What was the Agartala Conspiracy Case?',
        'options' => ['A conspiracy to overthrow the government', 'A case against Sheikh Mujibur Rahman', 'A case related to illegal arms trade', 'A conspiracy to assassinate the President'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'The historic March 7 speech was delivered at:',
        'options' => ['Suhrawardy Udyan', 'Dhaka University', 'Ramna Park', 'National Parliament House'],
        'correct' => 'option_a'
    ],
    [
        'question' => 'What year did the Partition of Bengal occur?',
        'options' => ['1905', '1947', '1952', '1971'],
        'correct' => 'option_a'
    ],
    [
        'question' => 'The official name of Bangladesh\'s first national parliament was:',
        'options' => ['Jatiya Sangsad', 'Gonobhaban', 'Sangsad Bhaban', 'Assembly House'],
        'correct' => 'option_a'
    ],
    [
        'question' => 'What was the name of the first Bengali newspaper?',
        'options' => ['Dainik Azad', 'Samachar Darpan', 'The Bengal Gazette', 'Amrita Bazar Patrika'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'What is the significance of April 17, 1971?',
        'options' => ['The declaration of independence', 'The formation of the first cabinet of the Provisional Government', 'The signing of the Instrument of Surrender', 'The start of the Liberation War'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'Which national monument commemorates the martyrs of the Language Movement?',
        'options' => ['Jatiya Smriti Soudh', 'Shaheed Minar', 'Smritishoudh', 'Central Shaheed Minar'],
        'correct' => 'option_d'
    ],
    [
        'question' => 'What was the name of the first woman to become a freedom fighter in Bangladesh?',
        'options' => ['Pritilata Waddedar', 'Begum Rokeya', 'Begum Sufia Kamal', 'Sultana Ahmed'],
        'correct' => 'option_a'
    ],
    [
        'question' => 'The name "Bangladesh" was officially declared on which date?',
        'options' => ['March 26, 1971', 'April 17, 1971', 'December 16, 1971', 'January 10, 1972'],
        'correct' => 'option_a'
    ],
    [
        'question' => 'What was the first capital of independent Bangladesh?',
        'options' => ['Dhaka', 'Mujibnagar', 'Chittagong', 'Mymensingh'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'Which famous Bengali poet wrote "Dukhu" (The Rebel Poet)?',
        'options' => ['Rabindranath Tagore', 'Kazi Nazrul Islam', 'Jasimuddin', 'Sukanta Bhattacharya'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'The name of the first provisional government was derived from:',
        'options' => ['A village in Meherpur district', 'A city in India', 'A military base', 'A historical place in Dhaka'],
        'correct' => 'option_a'
    ],
    [
        'question' => 'What was the name of the operation launched by the Mukti Bahini on Pakistani forces?',
        'options' => ['Operation Searchlight', 'Operation Jackpot', 'Operation Blitzkrieg', 'Operation Grand Slam'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'Who was the president of the Provisional Government of Bangladesh?',
        'options' => ['Sheikh Mujibur Rahman', 'Syed Nazrul Islam', 'Tajuddin Ahmad', 'Ziaur Rahman'],
        'correct' => 'option_a'
    ],
    [
        'question' => 'The `Gonobhaban` serves as the official residence of the:',
        'options' => ['Prime Minister of Bangladesh', 'President of Bangladesh', 'Speaker of the Parliament', 'Chief Justice of Bangladesh'],
        'correct' => 'option_a'
    ],
    [
        'question' => 'The first Bangladeshi constitution was adopted in:',
        'options' => ['1971', '1972', '1973', '1974'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'The historic `Six-Point Movement` was proposed by:',
        'options' => ['Maulana Bhashani', 'A. K. Fazlul Huq', 'Sheikh Mujibur Rahman', 'Suhrawardy'],
        'correct' => 'option_c'
    ],
    [
        'question' => 'What was the name of the military wing of the Provisional Government of Bangladesh?',
        'options' => ['Bangladesh Army', 'Mukti Bahini', 'Bangladesh Rifles', 'Para-commandos'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'The final surrender of the Pakistan Army took place at:',
        'options' => ['Dhaka University', 'Suhrawardy Udyan', 'Ramna Park', 'The National Parliament House'],
        'correct' => 'option_b'
    ],
    [
        'question' => 'The Bengali Language Movement of 1952 was a political movement that took place in:',
        'options' => ['East Pakistan', 'West Pakistan', 'East Bengal', 'West Bengal'],
        'correct' => 'option_a'
    ],
    [
        'question' => 'Who was the first chief of the Bangladesh Army?',
        'options' => ['General M. A. G. Osmani', 'General Ziaur Rahman', 'General Shafiul Azam', 'General H. M. Ershad'],
        'correct' => 'option_a'
    ],
    [
        'question' => 'The first Bangladeshi flag was officially adopted in:',
        'options' => ['1970', '1971', '1972', '1973'],
        'correct' => 'option_c'
    ],
    [
        'question' => 'The name "Bangladesh" was declared on March 26, 1971, by:',
        'options' => ['Sheikh Mujibur Rahman', 'Ziaur Rahman', 'Tajuddin Ahmad', 'Syed Nazrul Islam'],
        'correct' => 'option_a'
    ]
];

// Start populating the database
insertQuestions($conn, 'CSE', $cseQuestions);
insertQuestions($conn, 'Chemistry', $chemistryQuestions);
insertQuestions($conn, 'History of Bangladesh', $historyQuestions);

$conn->close();
?>

CREATE DATABASE IF NOT EXISTS `edtech_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `edtech_db`;

DROP TABLE IF EXISTS `courses`;
DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `slug` VARCHAR(120) NOT NULL,
  `description` TEXT NULL,
  `icon` VARCHAR(50) DEFAULT 'bi-collection',
  `status` ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_categories_slug` (`slug`),
  INDEX `idx_categories_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `courses` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` INT UNSIGNED NULL,
  `name` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `price` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
  `image` VARCHAR(255) NOT NULL,
  `short_description` VARCHAR(300) NOT NULL,
  `full_description` LONGTEXT NOT NULL,
  `duration` VARCHAR(100) NOT NULL,
  `level` ENUM('Beginner', 'Intermediate', 'Advanced', 'All Levels') NOT NULL DEFAULT 'All Levels',
  `is_featured` TINYINT(1) NOT NULL DEFAULT 0,
  `meta_title` VARCHAR(255) NULL,
  `meta_description` VARCHAR(300) NULL,
  `status` ENUM('published', 'draft', 'archived') NOT NULL DEFAULT 'published',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_courses_slug` (`slug`),
  INDEX `idx_courses_category_id` (`category_id`),
  INDEX `idx_courses_status` (`status`),
  INDEX `idx_courses_is_featured` (`is_featured`),
  CONSTRAINT `fk_courses_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `contact_messages`;

CREATE TABLE `contact_messages` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(120) NOT NULL,
  `email` VARCHAR(190) NOT NULL,
  `subject` VARCHAR(200) NOT NULL,
  `message` TEXT NOT NULL,
  `ip_address` VARCHAR(45) NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_contact_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `icon`, `status`) VALUES
(1, 'Web Development', 'web-development', 'Master modern front-end and back-end web development with hands-on projects.', 'bi-code-slash', 'active'),
(2, 'Data Science & AI', 'data-science-ai', 'Learn machine learning, data analytics, predictive models, and Python programming.', 'bi-cpu', 'active'),
(3, 'UI/UX Design', 'ui-ux-design', 'Design intuitive interfaces, interactive wireframes, and scalable design systems.', 'bi-palette', 'active'),
(4, 'Cloud & DevOps', 'cloud-devops', 'Deploy, automate, and orchestrate cloud infrastructure with AWS, Docker, and CI/CD.', 'bi-cloud-check', 'active'),
(5, 'Mobile Development', 'mobile-development', 'Build cross-platform iOS and Android apps using React Native and Flutter.', 'bi-phone', 'active'),
(6, 'Cybersecurity', 'cybersecurity', 'Protect computer systems, networks, and confidential data against modern threats.', 'bi-shield-check', 'active');

INSERT INTO `courses` (
  `id`, `category_id`, `name`, `slug`, `price`, `image`,
  `short_description`, `full_description`, `duration`, `level`,
  `is_featured`, `meta_title`, `meta_description`, `status`
) VALUES
(
  1,
  1,
  'Full-Stack Web Development Bootcamp',
  'fullstack-web-development-bootcamp',
  89.99,
  'assets/images/courses/web-dev.svg',
  'Master HTML5, CSS3, modern JavaScript, PHP, MySQL, and responsive design from scratch with real industry projects.',
  '<h3>Become a Job-Ready Full-Stack Web Developer</h3>
<p>This comprehensive bootcamp takes you from complete novice to confident full-stack engineer. You will learn modern semantic HTML5, CSS3, flexbox, CSS grid, and responsive frameworks such as Bootstrap 5. In the backend modules, you dive deep into Core PHP, object-oriented concepts, PDO database abstraction, and relational database design with MySQL.</p>
<h4>What You Will Learn:</h4>
<ul>
  <li>Semantic HTML5 architecture and web accessibility (a11y) standards</li>
  <li>Advanced CSS3 styling, custom properties, animations, and Bootstrap 5 grid systems</li>
  <li>Core PHP programming, server-side data validation, and session management</li>
  <li>Relational database modeling with MySQL, normalization, and indexing</li>
  <li>Secure CRUD operations using PDO and prepared statements to prevent SQL injection</li>
  <li>RESTful API design and dynamic client-server communication with Vanilla JavaScript</li>
</ul>
<h4>Course Curriculum Highlights:</h4>
<ol>
  <li><strong>Module 1:</strong> Foundations of the Modern Web (HTML5 & Modern CSS)</li>
  <li><strong>Module 2:</strong> JavaScript Essentials & Asynchronous DOM Manipulation</li>
  <li><strong>Module 3:</strong> Backend Engineering with Core PHP & MVC Concepts</li>
  <li><strong>Module 4:</strong> MySQL Database Architecture, Transactions & PDO Security</li>
  <li><strong>Module 5:</strong> Capstone Production Project: Interactive EdTech Platform</li>
</ol>',
  '12 Weeks (48 Hours)',
  'Beginner',
  1,
  'Full-Stack Web Development Bootcamp | EdTech Innovate',
  'Learn full-stack web development with HTML5, CSS3, PHP, and MySQL. Build real projects and gain job-ready engineering skills.',
  'published'
),
(
  2,
  1,
  'Modern JavaScript & Front-End Architecture',
  'modern-javascript-frontend-architecture',
  69.99,
  'assets/images/courses/js-architecture.svg',
  'Deep dive into ES6+, asynchronous patterns, modular design, DOM APIs, and scalable client-side web architectures.',
  '<h3>Take Your JavaScript to Professional Engineering Standards</h3>
<p>JavaScript is the lifeblood of interactive web applications. This course bypasses superficial tutorials and plunges directly into execution contexts, closures, prototypes, asynchronous JavaScript with Promises and async/await, and modern component architecture.</p>
<h4>Key Concepts Covered:</h4>
<ul>
  <li>Event loop, microtasks, macrotasks, and asynchronous execution under the hood</li>
  <li>Functional programming paradigms, immutability, and state management</li>
  <li>Modern Fetch API, HTTP headers, authentication tokens, and error handling</li>
  <li>Client-side routing, URL history management, and Single Page Application foundations</li>
  <li>Performance profiling, memory leak detection, and Lighthouse auditing</li>
</ul>',
  '8 Weeks (32 Hours)',
  'Intermediate',
  1,
  'Modern JavaScript & Front-End Architecture | EdTech Innovate',
  'Master ES6+, asynchronous programming, and clean client-side architecture with practical Vanilla JavaScript projects.',
  'published'
),
(
  3,
  2,
  'Python for Data Science and Machine Learning',
  'python-data-science-machine-learning',
  99.99,
  'assets/images/courses/python-data.svg',
  'Analyze real datasets, build predictive models, and master Python, NumPy, Pandas, Matplotlib, and Scikit-Learn.',
  '<h3>Harness Data to Make Intelligent Automated Decisions</h3>
<p>Data science and applied machine learning continue to reshape every major industry. This hands-on program provides an accessible yet rigorous journey into data wrangling, exploratory data analysis, statistical modeling, and machine learning pipelines using Python.</p>
<h4>Topics Explored:</h4>
<ul>
  <li>Python programming fundamentals optimized for scientific computing</li>
  <li>Data manipulation and cleaning using Pandas dataframes and NumPy arrays</li>
  <li>Visualizing correlations and distributions with Matplotlib and Seaborn</li>
  <li>Supervised learning algorithms: Linear/Logistic Regression, Decision Trees, and Random Forests</li>
  <li>Unsupervised learning: K-Means clustering and Dimensionality Reduction (PCA)</li>
  <li>Model evaluation metrics: ROC-AUC, precision, recall, and cross-validation</li>
</ul>',
  '10 Weeks (40 Hours)',
  'Beginner',
  1,
  'Python for Data Science & Machine Learning Course | EdTech Innovate',
  'Master data science and predictive analytics using Python, Pandas, and Scikit-Learn with hands-on projects.',
  'published'
),
(
  4,
  3,
  'UI/UX Design Systems & Figma Masterclass',
  'ui-ux-design-systems-figma',
  59.99,
  'assets/images/courses/ui-ux.svg',
  'Design user-centric interfaces, high-fidelity wireframes, interactive prototypes, and design tokens using Figma.',
  '<h3>Design Intuitive Products That Delight Users</h3>
<p>Learn the end-to-end product design process from user research and wireframing to creating enterprise-grade design systems. This course bridges the gap between creative visual design and technical front-end development constraints.</p>
<h4>What You Will Master:</h4>
<ul>
  <li>User personas, journey mapping, empathy maps, and competitive benchmarking</li>
  <li>Information architecture, low-fidelity wireframing, and rapid user testing</li>
  <li>Figma Auto-Layout 5.0, component variants, interactive components, and variables</li>
  <li>Design tokens, typography scales, accessible color contrast (WCAG AAA), and spacing rules</li>
  <li>Developer handoff workflows, inspecting CSS specs, and asset export strategies</li>
</ul>',
  '6 Weeks (24 Hours)',
  'All Levels',
  1,
  'UI/UX Design Systems & Figma Masterclass | EdTech Innovate',
  'Master UI/UX design, Figma prototypes, and design systems with our comprehensive hands-on product design course.',
  'published'
),
(
  5,
  4,
  'AWS Cloud Solutions Architect & DevOps',
  'aws-cloud-solutions-architect-devops',
  119.99,
  'assets/images/courses/cloud-aws.svg',
  'Architect high-availability cloud systems on Amazon Web Services and streamline deployments with Docker and CI/CD.',
  '<h3>Build Scalable, Secure Cloud Infrastructures on AWS</h3>
<p>Prepare for the AWS Certified Solutions Architect Associate exam while gaining practical engineering experience deploying modern web services. Learn how to architect multi-tier cloud applications that are resilient, fault-tolerant, and cost-effective.</p>
<h4>Key Cloud Competencies:</h4>
<ul>
  <li>Core AWS infrastructure: VPC, Subnets, Internet Gateways, NAT, and Security Groups</li>
  <li>Compute and serverless: EC2, Auto-scaling groups, Elastic Load Balancers, and AWS Lambda</li>
  <li>Storage and databases: S3 object storage, RDS multi-AZ instances, and DynamoDB</li>
  <li>Containerization: Dockerizing PHP & MySQL applications and deploying to ECS</li>
  <li>Infrastructure as Code (IaC) principles and continuous deployment pipelines</li>
</ul>',
  '14 Weeks (56 Hours)',
  'Intermediate',
  0,
  'AWS Cloud Solutions Architect & DevOps Course | EdTech Innovate',
  'Architect high-availability cloud applications on AWS and automate deployments with Docker and CI/CD pipelines.',
  'published'
),
(
  6,
  5,
  'Cross-Platform Mobile Apps with React Native',
  'cross-platform-react-native',
  79.99,
  'assets/images/courses/mobile-react-native.svg',
  'Build native iOS and Android mobile apps from a single JavaScript codebase using React Native and Expo.',
  '<h3>One Codebase, Two App Stores</h3>
<p>Ship production-ready native applications for both Apple iOS and Google Android. Learn how React Native maps JavaScript components directly to native platform UI widgets for optimal 60fps performance.</p>
<h4>Topics Covered:</h4>
<ul>
  <li>React Native primitives: View, Text, ScrollView, FlatList, and Touchable controls</li>
  <li>Platform-specific navigation patterns using React Navigation</li>
  <li>Accessing device hardware: Camera, Geolocation, Accelerometer, and Push Notifications</li>
  <li>State management across mobile screen stacks and offline data caching</li>
  <li>Publishing applications to Apple App Store and Google Play Store</li>
</ul>',
  '8 Weeks (30 Hours)',
  'Intermediate',
  0,
  'Cross-Platform Mobile Apps with React Native | EdTech Innovate',
  'Learn cross-platform mobile app development with React Native and Expo for iOS and Android devices.',
  'published'
),
(
  7,
  6,
  'Hands-on Ethical Hacking & Cyber Defense',
  'hands-on-ethical-hacking-cybersecurity',
  0.00,
  'assets/images/courses/cyber-security.svg',
  'Learn the fundamentals of penetration testing, network defense, threat analysis, and web application security for free.',
  '<h3>Defend Digital Assets and Understand Vulnerabilities</h3>
<p>Learn how cybersecurity professionals find and fix vulnerabilities before malicious actors can exploit them. This introductory course covers network reconnaissance, scanning tools, OWASP Top 10 web vulnerabilities, and security hardening strategies.</p>
<h4>What You Will Explore:</h4>
<ul>
  <li>Ethical hacking methodology, legal considerations, and penetration testing phases</li>
  <li>Network port scanning and service fingerprinting with Nmap and Wireshark</li>
  <li>OWASP Top 10 vulnerabilities: SQL Injection, Cross-Site Scripting (XSS), and CSRF</li>
  <li>Password cracking mechanics and credential protection best practices</li>
  <li>Defensive security: Firewalls, IDS/IPS configuration, and patch management</li>
</ul>',
  '4 Weeks (16 Hours)',
  'Beginner',
  0,
  'Hands-on Ethical Hacking & Cyber Defense | EdTech Innovate',
  'Free introductory ethical hacking and network security course. Understand OWASP vulnerabilities and cyber defenses.',
  'published'
),
(
  8,
  4,
  'Docker, Kubernetes & Production CI/CD Pipelines',
  'docker-kubernetes-cicd',
  84.99,
  'assets/images/courses/devops-docker.svg',
  'Containerize multi-container web stacks, automate testing, and orchestrate container clusters with Kubernetes.',
  '<h3>Automate and Containerize Modern Engineering Workflows</h3>
<p>Bridge the gap between development and operations. Learn how containerization ensures consistent execution across development laptops, staging environments, and production Kubernetes clusters.</p>
<h4>Key Learning Outcomes:</h4>
<ul>
  <li>Writing clean, lightweight, multi-stage Dockerfiles for web applications</li>
  <li>Managing multi-container environments using Docker Compose</li>
  <li>Kubernetes architecture: Pods, Services, Deployments, ConfigMaps, and Secrets</li>
  <li>Automated testing and linting pipelines with GitHub Actions</li>
  <li>Zero-downtime rolling updates, health checks, and ingress controllers</li>
</ul>',
  '7 Weeks (28 Hours)',
  'Advanced',
  0,
  'Docker, Kubernetes & CI/CD Pipelines | EdTech Innovate',
  'Master containerization, Kubernetes orchestration, and automated CI/CD pipelines for production deployments.',
  'published'
),
(
  9,
  2,
  'Deep Learning & Large Language Models (Draft / Internal)',
  'deep-learning-large-language-models-draft',
  149.99,
  'assets/images/courses/machine-learning.svg',
  'Internal curriculum draft for generative AI, transformers, fine-tuning LLMs, and neural network architectures.',
  '<p>This course is currently undergoing curriculum review and is unpublished.</p>',
  '16 Weeks (64 Hours)',
  'Advanced',
  0,
  'Deep Learning & LLMs | EdTech Innovate',
  'Curriculum draft for deep learning and LLMs.',
  'draft'
);

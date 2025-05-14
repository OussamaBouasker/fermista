# Fermista
Integrated project symfony-java 
## Overview
This project was developed as part of the coursework for PIDEV 3A44 at [Esprit University](https://esprit.tn).  
**Fermista** is an intelligent real-time monitoring platform for dairy farms. It integrates a smart collar composed of a custom electronic board and sensors that track the health and behavior of cows.  
The platform provides a real-time dashboard for data visualization, including estrus detection and health anomalies. It also offers:

- A **medical management module** where farmers can book appointments and veterinarians can manage online consultations.
- An **e-commerce module** for buying and selling dairy products.
- An **online workshop module** to educate farmers on the technology and promote best practices.

## Features
- 🔔 Real-time monitoring of cow activity and health
- 📊 Dashboard with sensor data visualization
- 🩺 Online veterinary consultation and appointment booking
- 🛒 Dairy product e-commerce system
- 🎓 Interactive online workshops
- 👨🌾 Multi-role system: farmer, veterinarian, admin,client

## Tech Stack

### Frontend
- HTML5, CSS3
- Bootstrap 5
- JavaScript
- Twig (Symfony templating engine)

### Backend
- PHP 8.x
- Symfony 6.4
- Doctrine ORM
- MySQL
### APIs & External Services
- **Mailtrap API**
- **reCAPTCHA v2** 
- **Maps API** 
- **PDF Generator** 
- **Gemini AI API**
  
### Other Tools
- Git & GitHub
- Composer
- Postman (API testing)
- Figma (UI design)
- Smart collar: Custom embedded system (ESP32 + sensors)
- Chart.js (Data visualization)

## Directory Structure
📁FERMISTA/
├── 📁 assets/
├── 📁 bin/
├── 📁 config/
├── 📁 migrations/
├── 📁 public/
│   ├── 📁 Back/
│   ├── 📁 Front/
│   ├── 📁 models/
│   ├── 📁 uploads/
│   └── 📄 index.php
├── 📁 src/
│   ├── 📁 Controller/
│   ├── 📁 Entity/
│   ├── 📁 Form/
│   ├── 📁 Repository/
│   ├── 📁 Security/
│   │   ├── 📄 EmailVerifier.php
│   │   └── 📄 LoginFormAuthenticator.php
│   └── 📄 Kernel.php
├── 📁 templates/
├── 📁 tests/
├── 📁 translations/
├── 📁 var/
├── 📁 vendor/
├── 📄 .env
├── 📄 .env.dev
├── 📄 .env.test
├── 📄 .gitignore
├── 📄 compose.override.yaml
└── 📄 compose.yaml







## Getting Started

1. **Clone the repository**
   
   git clone https://github.com/your-username/fermista.git
   cd fermista
   
2. Install dependencies
composer install
npm install
npm run build

3. Set up the environment
cp .env .env.local
# Configure your DB and mailer settings in .env.local

4. Create and migrate the database
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

5. Run the development server
symfony server:start

6. Access the app
Go to http://localhost:8000 in your browser.

## Acknowledgments
This project was completed under the guidance of [Safouene Zouari](safouene.zouari@esprit.tn) at Esprit University.


# Dynamic Form Builder and Feedback Analysis System

This project is a web application designed for creating dynamic forms using a user-friendly form builder. The forms can be saved in the database and displayed dynamically for users to fill out. The application also allows admins to view user-submitted data, analyze feedback on a daily and monthly basis, and receive real-time notifications when feedback forms are submitted.

## Features

### Dynamic Form Builder
- Create dynamic forms with custom schema and user-friendly field names.
- Add options for form fields such as input types, placeholders, and validations.
- Save form schema in the database for reuse.

### User Feedback Collection
- Display the created forms dynamically for users.
- Allow users to submit feedback using the dynamic forms.

### Admin Dashboard
- View user-submitted feedback data.
- Analyze feedback trends using line charts (daily and monthly basis).
- Manage and review all submitted forms.

### Real-Time Notifications
- Implement real-time notifications using the Pusher Laravel package.
- Show a toaster notification in the admin dashboard when a user submits a feedback form.

## Technologies Used

### Frontend
- **HTML**
- **CSS**
- **JavaScript**
- **jQuery**

### Backend
- **PHP**
- **Laravel Framework**

### Live Notification System
- **Pusher Laravel Package**

### Charts
- **Chart.js** (for displaying feedback trends in line charts)

## Installation

### Prerequisites
Ensure you have the following installed on your system:
- PHP (>= 8.0)
- Composer
- Node.js and npm
- MySQL

### Steps
1. Clone the repository:
   ```bash
   git clone https://github.com/Shareiar-shams/Online-Feedback-Collection.git
   ```

2. Navigate to the project directory:
   ```bash
   cd dynamic-form-builder
   ```

3. Install dependencies:
   ```bash
   composer install
   npm install
   npm run dev
   ```

4. Set up the `.env` file:
   - Copy `.env.example` to `.env`
   - Configure the database connection:
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=your_database_name
     DB_USERNAME=your_database_user
     DB_PASSWORD=your_database_password
     ```
   - Configure Pusher credentials:
     ```env
     BROADCAST_DRIVER=pusher
     PUSHER_APP_ID=your-app-id
     PUSHER_APP_KEY=your-app-key
     PUSHER_APP_SECRET=your-app-secret
     PUSHER_APP_CLUSTER=your-cluster
     ```

5. Run database migrations:
   ```bash
   php artisan migrate
   ```

6. Start the development server:
   ```bash
   php artisan serve
   ```

## Usage

### Creating a Dynamic Form
1. Log in as an admin.
2. Navigate to the "Form Builder" section.
3. Add fields to your form and configure their properties.
4. Save the form schema to the database.

### User Feedback
1. Users can access forms dynamically displayed in the user portal.
2. Submit feedback through the provided forms.

### Admin Dashboard
1. View all submitted feedback in the dashboard.
2. Analyze trends in feedback using the line chart visualization.
3. Receive real-time toaster notifications for new feedback submissions.

## Real-Time Notifications Setup
1. Ensure Pusher credentials are correctly configured in the `.env` file.
2. Verify that broadcasting works by testing the Pusher Debug Console.
3. Check Laravel logs for any errors if notifications are not working.

## Project Structure
- **Frontend**: Implements form creation, user-friendly UI, and charts.
- **Backend**: Manages dynamic form schemas, user submissions, and broadcasting.
- **Notifications**: Handles real-time updates using Pusher.

## Contribution
Feel free to contribute to this project by submitting issues or pull requests. Follow these steps:
1. Fork the repository.
2. Create a new branch:
   ```bash
   git checkout -b feature-name
   ```
3. Commit changes and push to the branch.
4. Open a pull request.


---

For any queries or support, feel free to contact [islamshareiar@gmail.com].


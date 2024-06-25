<p align="center"><a href="https://github.com/Maysker/bitcoin-trackerV2" target="_blank"><img src="https://raw.githubusercontent.com/Maysker/squadscope/master/public/images/logo.png" width="500" alt="Squad Scope Logo"></a></p>

# Squad Scope

**Squad Scope** is a PUBG squad statistics and analytics application. It helps you dive deep into match analysis, assess individual and team stats, and utilize tactical tools to craft winning strategies. Improve your chances of victory and become PUBG champions with our app!

## Features

- **Match Analysis**: Detailed statistics for each match.
- **Team Statistics**: Overall and individual player stats.
- **Team Management**: Create and manage teams.
- **User Authentication**: Registration and login functionality.
- **User-friendly Interface**: Responsive design for better user experience.

## Installation

1. Clone the repository:

    ```bash
    git clone https://github.com/AntonioMaggi/squadscope.git
    cd squadscope
    ```

2. Install dependencies:

    ```bash
    composer install
    npm install
    ```

3. Configure your `.env` file:

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. Set up the database in your `.env` file and run the migrations:

    ```bash
    php artisan migrate
    ```

5. Install Breeze and Livewire:

    ```bash
    composer require laravel/breeze --dev
    php artisan breeze:install
    php artisan migrate
    npm install && npm run dev
    ```

## Running the Application

To run the application, you will need to open two terminal windows or tabs:

1. In the first terminal, start the PHP development server:

    ```bash
    php artisan serve
    ```

2. In the second terminal, start the Vite development server:

    ```bash
    npm run dev
    ```

3. Open your browser and navigate to [http://localhost:8000](http://localhost:8000).

## Usage

After launching the application, open your browser and go to [http://localhost:8000](http://localhost:8000). Register or log in to use all the features of the application.

## Developers

- [Adam Gazdiev](https://github.com/Maysker)
- [Antonio Maggi](https://github.com/AntonioMaggi)

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

## Contributing

We welcome contributions from the community! If you have suggestions or find a bug, please create an issue or submit a pull request.

## Acknowledgments

This project was created as a graduation thesis by students of the Full Stack Developer course at Syntra PXL.

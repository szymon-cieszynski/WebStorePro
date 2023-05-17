# WebStorePro

WebStorePro is an e-commerce web application built with Symfony framework.

## Features

- Shopping cart: Add products to the shopping cart, adjust quantities, and proceed to checkout.

## Installation

Follow these steps to install and run the application:

1. Clone the repository: `git clone https://github.com/your-username/WebStorePro.git`
2. Install dependencies: `composer install`
3. Set up the database configuration in the `.env` file.
4. Create the database: `php bin/console doctrine:database:create`
5. Run database migrations: `php bin/console doctrine:migrations:migrate`
6. Load sample data (optional): `php bin/console doctrine:fixtures:load`
7. Start the development server: `symfony serve -d`

## Usage

1. Access the application in your web browser: `http://localhost:8000`
2. Browse the products, add items to the cart, and proceed to checkout.
3. Customize the application by modifying the templates, stylesheets, and controllers.

## Contributing

Contributions are welcome! If you find any issues or have suggestions for improvement, please submit an issue or a pull request.

## License

This project is licensed under the [MIT License](https://opensource.org/licenses/MIT).


## Contact

For any inquiries or questions, please contact me at cieszynski8@gmail.com

Enjoy using WebStorePro!

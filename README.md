# MySQL Explorer

MySQL Explorer is a PHP-based utility designed to facilitate the exploration of MySQL and MariaDB databases. It enables users to build and manage database queries efficiently, offering a suite of tools for visualizing database schemas, approximating table sizes, and generating SQL queries for various database operations.

## Features

- **Database Exploration**: Visualize and list all tables within a database, including approximate table sizes.
- **Query Building**: Dynamically build SQL queries for different operations, such as listing table columns, showing indexes, and counting table rows.
- **Custom Query Templates**: Utilize and modify predefined query templates for common database tasks.

## Installation

To get started with MySQL Explorer, follow these steps:

1. Ensure you have PHP 8.2 or later installed on your system.
2. Clone this repository to your local machine or server where you intend to run the utility.
   ```sh
   git clone https://github.com/tristancrushing//MySQL-Explorer/MySQL-Explorer.git
   ```
3. Navigate into the cloned directory.
   ```sh
   cd MySQL-Explorer
   ```
4. (Optional) Configure your database connection settings in a configuration file or directly within the PHP scripts, as required by your setup.

## Usage

To use MySQL Explorer, run the `main.php` script from the command line, specifying any required arguments or options.

```sh
php main.php --database your_database_name
```

### Example

Here's a simple example of how to list all tables in a database along with their approximate sizes:

```php
require 'main.php';

$args = ['database_name' => 'your_database_name'];
$result = main($args);

print_r($result);
```

This will output a list of tables in the specified database along with their sizes.

## Contributing

Contributions to MySQL Explorer are welcome and greatly appreciated. If you have suggestions for improvements or have identified bugs, please open an issue or submit a pull request.

1. Fork the repository.
2. Create your feature branch (`git checkout -b feature/AmazingFeature`).
3. Commit your changes (`git commit -am 'Add some AmazingFeature'`).
4. Push to the branch (`git push origin feature/AmazingFeature`).
5. Open a pull request.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Acknowledgments

- Thank you to all contributors who have helped to make this project a reality.
- Special thanks to the PHP and MySQL/MariaDB communities for their invaluable resources and support.

### Notes:

- **Customization**: Replace placeholder URLs and names (like `https://github.com/tristancrushing//MySQL-Explorer/MySQL-Explorer.git`) with actual links and names related to your project.
- **Configuration and Setup**: Provide more detailed setup and configuration instructions if your application requires them, especially regarding connecting to the MySQL/MariaDB databases.
- **Usage Examples**: Expand the usage section with more examples as your utility grows in functionality.
- **License Information**: Make sure to include the actual license text in a `LICENSE` file in your repository if you're using an open-source license.

This README.md provides a solid foundation for your project documentation but remember to update it as your project evolves.

FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

# Update and install OS's basic packages
RUN apt-get update
RUN apt-get install -y \
    libzip-dev\
    libpng-dev\
    libjpeg62-turbo-dev\
    libfreetype6-dev

# Install dependencies
RUN apt-get install -y \
    nano\
    build-essential\
    poppler-utils\
    npm\
    default-mysql-client\
    locales\
    zip\
    curl\
    jpegoptim optipng pngquant gifsicle\
    vim\
    unzip\
    git\
    libxml2-dev\
    libxslt-dev\
    python-dev-is-python3\
    libonig-dev\
    wget

ENV LANG=C.UTF-8

RUN apt-get install -y gconf-service libasound2 libgbm-dev libatk1.0-0 libc6 libcairo2 libcups2 libdbus-1-3 libexpat1 libfontconfig1 libgcc1 libgconf-2-4 libgdk-pixbuf2.0-0 libglib2.0-0 libgtk-3-0 libnspr4 libpango-1.0-0 libpangocairo-1.0-0 libstdc++6 libx11-6 libx11-xcb1 libxcb1 libxcomposite1 libxcursor1 libxdamage1 libxext6 libxfixes3 libxi6 libxrandr2 libxrender1 libxss1 libxtst6 ca-certificates fonts-liberation libnss3 lsb-release xdg-utils wget

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash -
RUN apt-get install nodejs -y

# Install extensions
RUN docker-php-ext-install soap xsl sockets
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath
RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/
RUN docker-php-ext-install gd

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Python 3.11 and pip
RUN apt-get update && apt-get install -y \
    python3.11 \
    python3.11-venv \
    python3.11-dev \
    python3-pip \
    && update-alternatives --install /usr/bin/python3 python3 /usr/bin/python3.11 1 \
    && python3 -m venv /opt/venv \
    && /opt/venv/bin/pip install --upgrade pip

ENV PATH="/opt/venv/bin:$PATH"

# Install Python packages
RUN python3 -m pip install numpy pandas tensorflow==2.18 matplotlib seaborn opencv-python pillow scikit-learn statsmodels split-folders

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory permissions
RUN chown -R www:www /var/www

# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]

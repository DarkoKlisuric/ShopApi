Steps for installation.

a) Configuration of server. In my case Nginx. 
    1. sudo nano /etc/nginx/sites-available/shopApi
    
    2. In shopApi paste this: 
    
    server { 
        listen 80;
        listen [::]:80;
        root /home/klisuric/shopApi/public;
        index index.php index.html index.htm index.nginx-debian.html;
        server_name local.shopapi.hr www.local.shopapi.hr;
        location / { try_files $uri /index.php$is_args$args;
      }
        location ~ \.php$ { fastcgi_buffer_size 128k;
        fastcgi_buffers 4 256k;
        fastcgi_busy_buffers_size 256k;
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php7.4-fpm.sock;
      } location ~ /\.ht { deny all; }
        location ~ ^/\.php(/|$) { 
        fastcgi_pass unix:/run/php/php7.4-fpm.sock;
        fastcgi_split_path_info ^(.+\.php)(/.*)$;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        fastcgi_param DOCUMENT_ROOT $realpath_root;
        internal; 
      }
        location ~ \.php$ { return 404; }
      }
    
    3. Creating soft link.
      - sudo ln -s /etc/nginx/sites-available/shopApi /etc/nginx/sites-enabled/
      
    4. sudo nano /etc/hosts 
     - add this
     - 127.0.0.1 local.shopApi.hr
    
    5. Test if everything is ok 
     - sudo nginx -t  
   
    6. sudo systemctl restart nginx.service

b) Creating project 
    1. Install Symfony CLI 
      - https://symfony.com/download
      
    2. symfony new ShopApi 
    
    3. Go to http://local.shopapi.hr/

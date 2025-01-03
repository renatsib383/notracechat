server {
	server_name tgchat.atloncrm.ru www.tgchat.atloncrm.ru;
	charset off;
	index index.php index.html;
	disable_symlinks if_not_owner from=$root_path;
	include /etc/nginx/vhosts-includes/*.conf;
	include /etc/nginx/vhosts-resources/tgchat.atloncrm.ru/*.conf;
	access_log /var/www/httpd-logs/tgchat.atloncrm.ru.access.log;
	error_log /var/www/httpd-logs/tgchat.atloncrm.ru.error.log notice;
	ssi on;
	set $root_path /var/www/www-root/data/www/tgchat.atloncrm.ru/public;
	root $root_path;
	listen 85.209.9.153:80;
	gzip on;
	gzip_comp_level 5;
	gzip_disable "msie6";
	gzip_types text/plain text/css application/json application/x-javascript text/xml application/xml application/xml+rss text/javascript application/javascript image/svg+xml;
	location / {
		location ~ [^/]\.ph(p\d*|tml)$ {
			try_files /does_not_exists @fallback;
		}
		location ~* ^.+\.(jpg|jpeg|gif|png|svg|js|css|mp3|ogg|mpe?g|avi|zip|gz|bz2?|rar|swf|webp|woff|woff2)$ {
			expires 24h;
			try_files $uri $uri/ @fallback;
		}
		location / {
			try_files /does_not_exists @fallback;
		}
	}
	location @fallback {
		include /etc/nginx/vhosts-resources/tgchat.atloncrm.ru/dynamic/*.conf;
		proxy_pass http://127.0.0.1:8080;
		proxy_redirect http://127.0.0.1:8080 /;
		proxy_set_header Host $host;
		proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
		proxy_set_header X-Forwarded-Proto $scheme;
		proxy_set_header X-Forwarded-Port $server_port;
		access_log off;
	}
	
	# Добавляем настройки для WebSocket
    location /app {
        proxy_http_version 1.1;
        proxy_set_header Host $http_host;
        proxy_set_header Scheme $scheme;
        proxy_set_header SERVER_PORT $server_port;
        proxy_set_header REMOTE_ADDR $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection "Upgrade";

        proxy_pass http://127.0.0.1:9000;
    }

    # Добавляем настройки для Reverb API
    location /apps {
        proxy_http_version 1.1;
        proxy_set_header Host $http_host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;

        proxy_pass http://127.0.0.1:9000;
    }
}
server {
	server_name tgchat.atloncrm.ru www.tgchat.atloncrm.ru;
	ssl_certificate "/var/www/httpd-cert/www-root/tgchat.atloncrm.ru_le1.crtca";
	ssl_certificate_key "/var/www/httpd-cert/www-root/tgchat.atloncrm.ru_le1.key";
	ssl_ciphers EECDH:+AES256:-3DES:RSA+AES:!NULL:!RC4;
	ssl_prefer_server_ciphers on;
	ssl_protocols TLSv1 TLSv1.1 TLSv1.2 TLSv1.3;
	ssl_dhparam /etc/ssl/certs/dhparam4096.pem;
	charset off;
	index index.php index.html;
	disable_symlinks if_not_owner from=$root_path;
	include /etc/nginx/vhosts-includes/*.conf;
	include /etc/nginx/vhosts-resources/tgchat.atloncrm.ru/*.conf;
	access_log /var/www/httpd-logs/tgchat.atloncrm.ru.access.log;
	error_log /var/www/httpd-logs/tgchat.atloncrm.ru.error.log notice;
	ssi on;
	set $root_path /var/www/www-root/data/www/tgchat.atloncrm.ru/public;
	root $root_path;
	listen 85.209.9.153:443 ssl;
	gzip on;
	gzip_comp_level 5;
	gzip_disable "msie6";
	gzip_types text/plain text/css application/json application/x-javascript text/xml application/xml application/xml+rss text/javascript application/javascript image/svg+xml;
	location / {
		location ~ [^/]\.ph(p\d*|tml)$ {
			try_files /does_not_exists @fallback;
		}
		location ~* ^.+\.(jpg|jpeg|gif|png|svg|js|css|mp3|ogg|mpe?g|avi|zip|gz|bz2?|rar|swf|webp|woff|woff2)$ {
			expires 24h;
			try_files $uri $uri/ @fallback;
		}
		location / {
			try_files /does_not_exists @fallback;
		}
	}
	location @fallback {
		include /etc/nginx/vhosts-resources/tgchat.atloncrm.ru/dynamic/*.conf;
		proxy_pass http://127.0.0.1:8080;
		proxy_redirect http://127.0.0.1:8080 /;
		proxy_set_header Host $host;
		proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
		proxy_set_header X-Forwarded-Proto $scheme;
		proxy_set_header X-Forwarded-Port $server_port;
		access_log off;
	}
	
	location /app {
        proxy_http_version 1.1;
        proxy_set_header Host $http_host;
        proxy_set_header Scheme $scheme;
        proxy_set_header SERVER_PORT $server_port;
        proxy_set_header REMOTE_ADDR $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection "Upgrade";

        proxy_pass http://127.0.0.1:9000;
    }

    location /apps {
        proxy_http_version 1.1;
        proxy_set_header Host $http_host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;

        proxy_pass http://127.0.0.1:9000;
    }
}

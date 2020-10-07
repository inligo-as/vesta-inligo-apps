server {
    listen      %ip%:%proxy_port%;
    server_name %domain_idn% %alias_idn%;
    location / {
	include %home%/%user%/web/%domain%/private/redirect.nginx.conf;
    }
include %home%/%user%/conf/web/*nginx.%domain_idn%.conf_letsencrypt;
}
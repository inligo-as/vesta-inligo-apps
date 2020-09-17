server {
    listen      %ip%:%proxy_port%;
    server_name %domain_idn% %alias_idn%;
    error_log  /var/log/%web_system%/domains/%domain%.error.log error;

    location / {
        include %home%/%user%/web/%domain%/private/app.nginx.conf;
    }

    location /error/ {
        alias   %home%/%user%/web/%domain%/document_errors/;
    }

    location @fallback {
        proxy_pass      http://%ip%:%web_port%;
    }

    location ~ /\.ht    {return 404;}
    location ~ /\.svn/  {return 404;}
    location ~ /\.git/  {return 404;}
    location ~ /\.hg/   {return 404;}
    location ~ /\.bzr/  {return 404;}

    include %home%/%user%/conf/web/nginx.%domain%.conf*;

#    ### security.txt ###

    set $contact ""; set $encryption ""; set $acknowledgements ""; set $preferredlanguages ""; set $canonical ""; set $policy ""; set $hiring "";
    set $contact "Contact: mailto:security@inligo.no\n";
    set $preferredlanguages "Preferred-Languages: no, en\n";
    set $canonical "Canonical: https://%domain%/.well-known/security.txt\n";
    set $encryption "Encryption: https://inligo.no/pgp/security@inligo.no.txt\n";

    set $securitytxt "${contact}${encryption}${acknowledgements}${preferredlanguages}${canonical}${policy}${hiring}";

    location /.well-known/security.txt {
        add_header Content-Type text/plain;
        return 200 $securitytxt;
    }

    location /security.txt {
        add_header Content-Type text/plain;
        return 200 $securitytxt;
    }
}
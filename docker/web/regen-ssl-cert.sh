openssl req -x509 -nodes -days 365 -subj "//x=1/C=CA/ST=QC/O=Company, Inc./CN=farthing.test" -addext "subjectAltName=DNS:farthing.test" -newkey rsa:2048 -keyout docker/web/ssl/ssl.key -out docker/web/ssl/ssl.crt

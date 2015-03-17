FROM tutum/lamp:latest
RUN apt-get update && apt-get dist-upgrade -qq -y
RUN apt-get install -qq -y php5-curl php5-ldap php5-gd php5-mcrypt
RUN apt-get -yy install vim

RUN a2enmod headers && a2enmod expires
RUN php5enmod mcrypt

RUN rm -fr /app
COPY processmaker /app
ADD processmaker/virtualhost.conf.example /etc/apache2/sites-available/000-default.conf


RUN chown -R www-data /app/ && chmod -R 770 /app/


EXPOSE 80 3306
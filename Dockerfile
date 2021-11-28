FROM python:alpine

RUN wget https://github.com/mozilla/geckodriver/releases/download/v0.30.0/geckodriver-v0.30.0-linux64.tar.gz && tar xvfz geckodriver-v0.30.0-linux64.tar.gz && mv geckodriver /usr/local/bin/
RUN apk add firefox ttf-dejavu
RUN apk add gcc
RUN apk add py3-cffi py3-h11 py3-attrs py3-sniffio
RUN apk add libc-dev libffi-dev
RUN pip3 install selenium

ADD geogen.py /app/geogen.py 



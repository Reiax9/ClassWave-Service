import smtplib
from email.mime.text import MIMEText

# Configuración del correo
smtp_host = 'localhost'
smtp_port = 1025
from_addr = 'test@example.com'
to_addr = 'recipient@example.com'
subject = 'Test Email'
body = 'This is a test email.'

# Crear el mensaje de correo
msg = MIMEText(body)
msg['Subject'] = subject
msg['From'] = from_addr
msg['To'] = to_addr

# Enviar el correo
with smtplib.SMTP(smtp_host, smtp_port) as server:
    server.sendmail(from_addr, [to_addr], msg.as_string())

print("Correo enviado")

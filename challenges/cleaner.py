import os, os.path
import time

max_age = 3
exclude = ['.htaccess', 'cleaner.py']

print(f'Deleting files that are older than {max_age} minutes...')
while True:
    for file in os.listdir():
        if not os.path.isfile(file):
            continue

        elif file in exclude:
            continue

        elif time.time() - os.path.getmtime(file) >= max_age * 60:
            print(f'Removing {file}')
            os.remove(file)

    time.sleep(10)
# 🗄️File upload `(images🖼️: png, jpeg, jpg )` using raw PHP.

### I'v just started using PHP for the last 15 days and this is so far the best way i can handle file upload although there is a room for improvements.

### improvements to be added apart from the `UI` that looks terrible :
- Parts from the code could be refactored into separate reusable bloc of code (`Functions`...)
- Adding more flexibility to handle other type of images.
- Adding more Flexibility to handle other types of files like .pfd,.ppt,...
- Improving error handling but building a robust error stack checking for various errors and correspond to the each one of them.
- Adding database interaction.
- saving files to a third party lib like `AWS s3` instead of saving them to file system.
- ...

### Considerations:

    Image function could work until enabling ;extension=gd by removing the semicolon at the front inside the php.ini fill.

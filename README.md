# 🗄️File upload `(images🖼️: png, jpeg, jpg )` using raw PHP.

### I've just started using PHP for the last 15 days, and this is so far the best way I can handle file uploads, although there is room for improvement.

### improvements to be added apart from the `UI` that looks terrible :
- Parts from the code could be refactored into separate reusable blocs of code (`Functions`...)
- Adding more flexibility to handle other types of images.
- Adding more Flexibility to handle other types of files like .pfd,.ppt,...
- Improving error handling but building a robust error stack checking for various errors and corresponding to each one.
- Adding database interaction.
- saving files to a third-party provider like `AWS s3` instead of saving them to the file system.
- ...

### Considerations:

    The image functions could work until enabling ;extension=gd by removing the semicolon at the front inside the php.ini fill.

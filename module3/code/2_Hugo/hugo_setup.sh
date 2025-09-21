hugo new site my-portfolio

# Navigate to the directory
cd my-portfolio

# Initialize Git repository 
git init

# See what Hugo created
ls -la


# clone anake (or any themes)
git clone https://github.com/theNewDynamic/gohugo-theme-ananke.git themes/ananke

# git clone https://github.com/google/docsy themes/docsy

# Creat pages in content
## Copy the files

hugo new about.md
hugo new projects/_index.md
hugo new projects/student-api.md

hugo server -D

# Open your browser to:
# http://localhost:1313

hugo new posts/getting-started-with-hugo.md

mkdir -p static/css
touch static/css/custom.css

# Generate static files
hugo

# Check the output
ls public/

# Serve the built site locally
cd public && python -m http.server 8080
# Visit: http://localhost:8080

mkdir -p static/images

# Add project screenshots
## The files are already copied in the code directory
##cp ~/screenshots/student-api.png static/images/
##cp ~/screenshots/docker-dashboard.png static/images/

# Make pages from the templates
hugo new posts/test-post.md
hugo new projects/test-project.md
hugo new docs/test-doc.md


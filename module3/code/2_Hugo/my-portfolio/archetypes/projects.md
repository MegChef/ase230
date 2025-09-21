---
title: "{{ replace .Name "-" " " | title }}"
date: {{ .Date }}
draft: true
tags: []
categories: ["project"]
technologies: ["HTML", "CSS", "JavaScript"]
projectUrl: ""
githubUrl: ""
demo: ""
status: "In Progress" # Completed, In Progress, Planning
difficulty: "Intermediate" # Beginner, Intermediate, Advanced
---

# {{ replace .Name "-" " " | title }}

## Project Overview

Brief description of what this project does and why you built it.

## Technologies Used

- HTML
- CSS
- JavaScript
- [Add your technologies here]

## Features

- Feature 1
- Feature 2
- Feature 3

## Screenshots

![Project Screenshot](/images/projects/{{ .Name }}-screenshot.png)

## Challenges Faced

What difficulties did you encounter and how did you solve them?

## What I Learned

Key learning outcomes from this project.

## Future Improvements

What would you add or change?

## Links

- [Live Demo](your-demo-url-here)
- [GitHub Repository](your-github-url-here)

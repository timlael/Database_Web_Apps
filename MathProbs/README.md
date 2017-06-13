# MathProbs
php project to display Math problems from a MySQL database using LaTeX

Project 1. Manage Math Question Bank

Description

In this programming project, we will develop some features that help us maintain a Math Question Bank. We can add new math questions into the bank.Then you can edit any math question in the bank. We also need to assign each math question to an appropriate category, so that we can list thequestions based on their categories.

Requirements
1. Database
The initial data is given in the example Listing Math Questions, where you can find the database script file mathprobdb.sql in the db folder. Butthe current database only contains one table: problem. We will need two more tables for the category assignment feature.
 - Create a table called category, in which other than a column called name, an auto-increment internal Id is needed to identify all the categories.This Id will be used for editing any category and connecting a problem to a category through their Ids
 - Create a table called prob_cat_mapping, in which other than an auto-increment internal Id that identifies each mapping, we also need two morecolumns: problem_id and category_id. Using this table, we can establish the relationship between the problems and the categories.

2. User interface
You need to use HTML/CSS/JavaScript to create your user interface. The look may not be that important. The bottom line is that your interfacesupports all the features required for this project.

3. List questions
When you come to the page, all the math questions are listed. For simplicity, you are not required to do pagination on this page.

4. Enter questions
There is a question input area and a Submit button above the question list area. When you enter a math question, you do not need to do validationfor simplicity in this project. After you insert a new question, the page should be updated to list all the questions with the newest question ontop.

5. Edit questions
For each math question, you can associate it with an Edit button. When you click this button, a textarea that contains the content of the currentquestion is displayed. After you change the content and click the Update button, the question is modified.

6. Enter categories
You can decide if you want to use the second page to manage all the categories or just do it in the same page. You have an input field to allowusers to enter a category.

7. List categories
You can list all the categories in the database. You have the freedom to choose how to list those categories.

8. Edit categories
For each category, you associate it with an Edit button, so that a user can click it to pull its value in an editing input field. Then it can bemodified and updated. Again no validation is required.

9. Map questions to categories
In the question list page, you associate each question with a Choose Category dropdown list. A user can select a category from the dropdown list,and then click a Connect button. A mapping relationship is established between these two items. 

10. Assign one question to multiple categories
It is allowed to assign one question to multiple categories. After each category assignment for a question, you should display a list of categoriesthat the current question belongs to beside this question.

11. List questions based on categories
In the question list page, when you select a category, all the questions in this category are listed in the order that the most recent question isdisplayed first.

==========The End==========

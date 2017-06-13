# Videodb
php/MySQL database project to create video lessons using Youtube api
Project 2-3. Develop Video-Based Learning Tool
Description

Due to the time limitation, we make this project two parts: Part A (Quick references in videos) Part B (Quick video lesson production), so as to be treated as two projects in our plan. For simplicity, all of our video sources come from YouTube through their URLs (or their YouTube IDs). 

Part A: Quick references in videos   (10 points) Imagine in a typical video lesson, there are multiple concepts. After a student finishes the lesson, he or she needs to work on the exercise questions based on this lesson. When a question is related to a particular concept, usually this student may need to go back to the location of the concept in the video to study it again. In order to make this concept reference fast and less painful, we need to develop a feature by specifying the starting point and the duration for this concept in the video lesson, so that the student can get to the right point by a simple click. 

Part B: Quick video lesson production   (10 points) We know that creating a video lesson is very time consuming. Now we want to develop a feature in our tool that can help us speed up video lesson production using the existing sources. Suppose that we want to assemble a video lesson from several existing videos through a playlist. But for each individual video, we do not want to include the whole video into the playlist, we only need to take part of the video in our lesson. When we play the final playlist, we will go through those selected parts in individual videos and view the whole lesson smoothly. 
  
Requirements
1. Database
You need to create your own MySQL database to store the data, including video URLs, concepts, and the reference information, for this project. When you submit your project, make sure that you include the database script as a text file inside your project folder. 

2. User interface
Design your user interface that supports the features for this project. It is not important if it looks pretty or not, if only it functions well. 

3. Entering Video URLs
We will assume that all the videos are hosted in YouTube, and we access them through their YouTube URLs (or YouTube IDs). 
- Allow a user to enter a URL into the database through a simple interface. Before you enter a new URL, check if it already exists. If it already exists, do not enter it.
- For simplicity, you are not required to show any error message if the URL already exists.
- For each video, assign it a title to identify it. Later when we list the videos, we list their titles.
- Enter the title and the URL at the same time. URL must be unique, but the title is not required to be unique.

4. Listing the Videos
In your page, list all the titles of the videos. The order is not important. For simplicity, display all of them in one page. 

5. Tagging the Videos with Concepts (Part A)
If a video has not been associated with concepts, we can tag it with a sequence of concepts separated by commas. After a video is tagged, all the concepts are listed under the title. We do not require that these concepts can be edited. 

6. Assigning Starting Point and Duration to Each Concept (Part A)
For each concept associated with the video, you can assign the starting point and the duration in seconds. Then you can play this video at this concept. 

7. Making Lessons from Existing Videos (Part B)
In order to create a video lesson, we need to add existing videos to the lesson. 
- Create a lesson by entering the title for this lesson. After this lesson is created, it is automatically set as the current lesson.
- In your video list, you can add a video to the current lesson by clicking a button.
- Make sure that each video only appears in the lesson once.

8. Generating the Playlists (Part B)
Now we have a sequence of videos selected for a particular lesson. 
- For each video in the lesson, specify the starting point and duration in seconds, so that only this part is played in the final playlist.
- In this project, we only need to choose one segment for each video in the lesson. In a real world application, we allow multiple segments selected for each video.

9. Listing the Lessons (Part B)
List all the generated lessons by their titles. Beside each title, attach a Play button, and the user can play the lesson using its associated playlist. 

# Note: In this project, we only do simulation. You do not need to make real lessons.     

==========The End==========

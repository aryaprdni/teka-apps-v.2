package quizControllers

import (
	"context"
	"fmt"
	"net/http"

	"github.com/gin-gonic/gin"
	"go.mongodb.org/mongo-driver/bson"
	"go.mongodb.org/mongo-driver/bson/primitive"
	"go.mongodb.org/mongo-driver/mongo"

	"example.com/web-service-gin/models"
)

// GetAllquizs retrieves all quizs from the MongoDB collection
func GetAllquizes(c *gin.Context) {
	collection := c.MustGet("quizCollection").(*mongo.Collection)

	cursor, err := collection.Find(context.Background(), bson.M{})
	if err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": err.Error()})
		return
	}
	defer cursor.Close(context.Background())

	var quizes []models.Quiz
	if err := cursor.All(context.Background(), &quizes); err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": err.Error()})
		return
	}

	c.JSON(http.StatusOK, quizes)
}

func GetDetailQuiz(c *gin.Context) {
	collection := c.MustGet("quizCollection").(*mongo.Collection)

	id := c.Param("id")
	objectID, err := primitive.ObjectIDFromHex(id)
	if err != nil {
		fmt.Println("Invalid ID:", err)
		c.JSON(http.StatusBadRequest, gin.H{"error": "Invalid ID"})
		return
	}

	var result bson.M
	err = collection.FindOne(context.TODO(), bson.M{"_id": objectID}).Decode(&result)
	if err == mongo.ErrNoDocuments {
		fmt.Println("No quiz was found")
		c.JSON(http.StatusNotFound, gin.H{"error": "Quiz not found"})
		return
	}
	if err != nil {
		fmt.Println("Error retrieving quiz:", err)
		c.JSON(http.StatusInternalServerError, gin.H{"error": "Internal server error"})
		return
	}

	c.JSON(http.StatusOK, result)

}

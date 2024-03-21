package main

import (
	"context"
	"fmt"

	"example.com/web-service-gin/controllers/avatarControllers"
	"example.com/web-service-gin/controllers/diamondControllers"
	"example.com/web-service-gin/controllers/loginControllers"
	"example.com/web-service-gin/controllers/quizControllers"
	"example.com/web-service-gin/controllers/userControllers"
	mongodb "example.com/web-service-gin/db"
	"example.com/web-service-gin/pkg/middleware"
	"github.com/gin-gonic/gin"
)

func main() {
	client, err := mongodb.ConnectToMongoDB()
	if err != nil {
		fmt.Println("Error connecting to MongoDB:", err)
		return
	}
	defer client.Disconnect(context.Background())

	// Membuat koleksi "user" jika belum ada
	err = mongodb.CreateCollectionIfNotExists(client.Database("teka_apps"), "user")
	if err != nil {
		fmt.Println("Error creating collection:", err)
		return
	}

	// Menginisialisasi koleksi-koleksi yang diperlukan
	avatarCollection := client.Database("teka_apps").Collection("avatar")
	quizcCollection := client.Database("teka_apps").Collection("quiz")
	userCollection := client.Database("teka_apps").Collection("user")
	diamondCollection := client.Database("teka_apps").Collection("diamond")

	router := gin.Default()

	router.Use(func(c *gin.Context) {
		c.Set("avatarCollection", avatarCollection)
		c.Set("quizCollection", quizcCollection)
		c.Set("userCollection", userCollection)
		c.Set("diamondCollection", diamondCollection)
		c.Next()
	})

	// Registering route handlers
	router.GET("/api/v1/avatars", avatarControllers.GetAllAvatars)
	router.GET("/api/v1/avatar/:id", avatarControllers.GetDetailAvatar)
	router.GET("/api/v1/quiz", quizControllers.GetAllquizes)
	router.GET("/api/v1/quiz/:id", quizControllers.GetDetailQuiz)
	router.GET("/api/v1/users", userControllers.GetAllUsers)
	router.GET("/api/v1/users/:id", userControllers.GetDetailUser)
	router.GET("/api/v1/diamond", diamondControllers.GetAllDiamonds)
	router.GET("/api/v1/diamond/:id", diamondControllers.GetDetailDiamond)
	router.POST("/api/v1/register", loginControllers.Register)
	router.POST("/api/v1/login", loginControllers.Login)
	router.PATCH("/api/v1/user-update", middleware.Auth() ,loginControllers.UpdateUser)

	router.Run()
}

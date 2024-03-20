package loginControllers

import (
	"context"
	"net/http"
	"time"

	"example.com/web-service-gin/models"
	"example.com/web-service-gin/pkg/middleware"
	"github.com/dgrijalva/jwt-go"
	"github.com/gin-gonic/gin"
	"go.mongodb.org/mongo-driver/bson"
	"go.mongodb.org/mongo-driver/bson/primitive"
	"go.mongodb.org/mongo-driver/mongo"
)

func Register(c *gin.Context) {
    var user models.User

    // Bind data dari form-data ke struct User
    if err := c.ShouldBind(&user); err != nil {
        c.AbortWithStatusJSON(http.StatusBadRequest, gin.H{"message": err.Error()})
        return
    }

    // Periksa apakah objek userCollection ada dalam konteks
    userCollection, exists := c.Get("userCollection")
    if !exists {
        c.AbortWithStatusJSON(http.StatusInternalServerError, gin.H{"message": "Failed to get user collection"})
        return
    }

    // Konversi objek userCollection ke dalam tipe *mongo.Collection
    collection, ok := userCollection.(*mongo.Collection)
    if !ok {
        c.AbortWithStatusJSON(http.StatusInternalServerError, gin.H{"message": "Failed to get user collection"})
        return
    }

    // Simpan data user ke dalam database MongoDB
    _, err := collection.InsertOne(context.Background(), user)
    if err != nil {
        c.AbortWithStatusJSON(http.StatusInternalServerError, gin.H{"message": "Failed to insert user data", "error": err.Error()})
        return
    }

    // Memberikan respons ke klien
    c.JSON(http.StatusOK, gin.H{"message": "User registered successfully", "user": user})
}



var jwtKey = []byte("secret_key")

func Login(c *gin.Context) {
	var user models.User

	// Bind data JSON ke struct User
	if err := c.ShouldBindJSON(&user); err != nil {
		c.AbortWithStatusJSON(http.StatusBadRequest, gin.H{"message": err.Error()})
		return
	}

	// Periksa apakah objek userCollection ada dalam konteks
	userCollection, exists := c.Get("userCollection")
	if !exists {
		c.AbortWithStatusJSON(http.StatusInternalServerError, gin.H{"message": "Failed to get user collection"})
		return
	}

	// Konversi objek userCollection ke dalam tipe *mongo.Collection
	collection, ok := userCollection.(*mongo.Collection)
	if !ok {
		c.AbortWithStatusJSON(http.StatusInternalServerError, gin.H{"message": "Failed to get user collection"})
		return
	}

	// Mencari user berdasarkan email
	filter := bson.M{"email": user.Email}
	err := collection.FindOne(context.Background(), filter).Decode(&user)
	if err != nil {
		if err == mongo.ErrNoDocuments {
			// Jika user tidak ditemukan, kirimkan respons "user not found"
			c.JSON(http.StatusNotFound, gin.H{"message": "User not found"})
			return
		}
		// Jika terjadi kesalahan lain saat pencarian, kirimkan respons kesalahan internal server
		c.AbortWithStatusJSON(http.StatusInternalServerError, gin.H{"message": "Failed to find user", "error": err.Error()})
		return
	}

	// Jika user ditemukan, buat token JWT
	token := jwt.New(jwt.SigningMethodHS256)
	claims := token.Claims.(jwt.MapClaims)
	claims["email"] = user.Email
	claims["exp"] = time.Now().Add(time.Hour * 24).Unix() // Token akan kedaluwarsa dalam 24 jam

	// Tandatangani token dengan kunci rahasia dan dapatkan string token
	tokenString, err := token.SignedString(jwtKey)
	if err != nil {
		c.AbortWithStatusJSON(http.StatusInternalServerError, gin.H{"message": "Failed to create JWT token", "error": err.Error()})
		return
	}

	// Kirim respons ke klien dengan data pengguna dan token JWT
	c.JSON(http.StatusOK, gin.H{"message": "User found", "user": user, "token": tokenString})
}

func UpdateUser(c *gin.Context) {
    // Memanggil middleware Auth untuk memeriksa otorisasi pengguna
    authMiddleware := middleware.Auth()
    authMiddleware(c)

    // Mendapatkan klaim JWT dari konteks
    claims, exists := c.Get("claims")
    if !exists {
        c.AbortWithStatusJSON(http.StatusInternalServerError, gin.H{"message": "Failed to get user claims"})
        return
    }

    // Konversi klaim ke dalam bentuk map[string]interface{}
    claimsMap, ok := claims.(map[string]interface{})
    if !ok {
        c.AbortWithStatusJSON(http.StatusInternalServerError, gin.H{"message": "Failed to convert claims to map"})
        return
    }

    // Mendapatkan ID pengguna dari klaim JWT
    userID, ok := claimsMap["sub"].(string)
    if !ok {
        c.AbortWithStatusJSON(http.StatusInternalServerError, gin.H{"message": "Failed to get user ID from token"})
        return
    }

    // Mendapatkan data JSON yang dikirim oleh pengguna
    var user models.User
    if err := c.ShouldBindJSON(&user); err != nil {
        c.AbortWithStatusJSON(http.StatusBadRequest, gin.H{"message": err.Error()})
        return
    }

    // Periksa apakah objek userCollection ada dalam konteks
    userCollection, exists := c.Get("userCollection")
    if !exists || userCollection == nil {
        c.AbortWithStatusJSON(http.StatusInternalServerError, gin.H{"message": "Failed to get user collection"})
        return
    }

    // Konversi objek userCollection ke dalam tipe *mongo.Collection
    collection, ok := userCollection.(*mongo.Collection)
    if !ok || collection == nil {
        c.AbortWithStatusJSON(http.StatusInternalServerError, gin.H{"message": "Failed to get user collection"})
        return
    }

    // Membuat filter berdasarkan ID pengguna
    objectID, err := primitive.ObjectIDFromHex(userID)
    if err != nil {
        c.AbortWithStatusJSON(http.StatusBadRequest, gin.H{"message": "Invalid user ID"})
        return
    }
    filter := bson.M{"_id": objectID}

    // Membuat perubahan yang akan diterapkan berdasarkan data yang diterima dalam permintaan
    update := bson.M{}
    if user.Name != "" {
        update["name"] = user.Name
    }
    // if user.Avatar != "" {
    //     update["avatar"] = user.Avatar
    // }

    // Melakukan pembaruan di database MongoDB
    result, err := collection.UpdateOne(context.Background(), filter, bson.M{"$set": update})
    if err != nil {
        c.AbortWithStatusJSON(http.StatusInternalServerError, gin.H{"message": "Failed to update user", "error": err.Error()})
        return
    }

    // Jika tidak ada dokumen yang terpengaruh, kirimkan respons pengguna tidak ditemukan
    if result.ModifiedCount == 0 {
        c.JSON(http.StatusNotFound, gin.H{"message": "User not found"})
        return
    }

    // Kirim respons sukses
    c.JSON(http.StatusOK, gin.H{"message": "User updated successfully"})
}












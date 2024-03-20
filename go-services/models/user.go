package models

import (
	"mime/multipart"
	"time"
)

type User struct {
	ID               string    `json:"id" bson:"_id,omitempty"`
	Name             string    `form:"name" json:"name" binding:"required"`
	Email            string    `form:"email" json:"email" binding:"required"`
	Avatar           *multipart.FileHeader   `form:"avatar" json:"avatar"`
	// Avatar           string   `form:"avatar" json:"avatar"`
	PurchasedAvatars []string  `form:"purchased_avatars" json:"purchased_avatars"`
	Diamond          int       `form:"diamond" json:"diamond"`
	CreatedAt        time.Time `json:"created_at" bson:"created_at"`
	UpdatedAt        time.Time `json:"updated_at" bson:"updated_at"`
}

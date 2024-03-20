package configs

import (
	"time"

	"go.mongodb.org/mongo-driver/bson/primitive"
)

type User struct {
    Id       primitive.ObjectID `json:"id,omitempty"`
    Name     string             `json:"name,omitempty" validate:"required"`
    Email string             `json:"email,omitempty" validate:"required"`
    Diamond    int32               `bson:"diamond"`
	Avatar     string            `json:"avatar,omitempty"`
	PurchasedAvatars []string `json:"purchased_avatars,omitempty"`
	CreatedAt  time.Time          `json:"created_at,omitempty"`
	UpdatedAt  time.Time          `json:"updated_at,omitempty"`
}
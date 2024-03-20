package middleware

import (
	"net/http"
	"strings"

	jwtoken "example.com/web-service-gin/pkg/jwt"
	"github.com/gin-gonic/gin"
)

type ErrorResult struct {
    Code    int    `json:"code"`
    Message string `json:"message"`
}

// Middleware Auth
func Auth() gin.HandlerFunc {
    return func(c *gin.Context) {
        token := c.GetHeader("Authorization")
        if token == "" {
            c.JSON(http.StatusUnauthorized, ErrorResult{Code: http.StatusUnauthorized, Message: "Unauthorized: Missing token"})
            c.Abort()
            return
        }

        tokenParts := strings.Split(token, " ")
        if len(tokenParts) != 2 || tokenParts[0] != "Bearer" {
            c.JSON(http.StatusUnauthorized, ErrorResult{Code: http.StatusUnauthorized, Message: "Unauthorized: Invalid token"})
            c.Abort()
            return
        }

        claims, err := jwtoken.DecodeToken(tokenParts[1])
        if err != nil {
            c.JSON(http.StatusUnauthorized, ErrorResult{Code: http.StatusUnauthorized, Message: "Unauthorized: Invalid token"})
            c.Abort()
            return
        }

        // Convert the claims to a map[string]interface{} before setting it in the context
        claimsMap := make(map[string]interface{})
        for key, value := range claims {
            claimsMap[key] = value
        }

        // Set the claims in the context
        c.Set("claims", claimsMap)
        c.Next()
    }
}




-- Drop all existing tables.
-- DROP TABLE IF EXISTS users;
-- DROP TABLE IF EXISTS pcards;
-- DROP TABLE IF EXISTS telemetry;
-- DROP TABLE IF EXISTS otpRequests;

-- Create Users table.
CREATE TABLE IF NOT EXISTS users (
    id int NOT NULL AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
    pass VARCHAR(255) NOT NULL,

    -- Google Authenticator
    otpSecret VARCHAR(255) NOT NULL,
    otpRecoveryA VARCHAR(255) NOT NULL,
    otpRecoveryB VARCHAR(255) NOT NULL,
    otpRecoveryC VARCHAR(255) NOT NULL,
    hasOtp BOOLEAN NOT NULL DEFAULT 0,

    -- Account Settings
    points INT NOT NULL DEFAULT 0,
    isAdmin BOOLEAN NOT NULL DEFAULT 0,
    isBanned BOOLEAN NOT NULL DEFAULT 0,

    -- Account Dates.
    joinDate DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    loginDate DATETIME NOT NULL DEFAULT 0,

    -- Things that can't duplicate.
    PRIMARY KEY (id),
    UNIQUE KEY (username),
    -- OTP Keys should never duplicate.
    UNIQUE KEY (otpSecret),
    UNIQUE KEY (otpRecoveryA),
    UNIQUE KEY (otpRecoveryB),
    UNIQUE KEY (otpRecoveryC)
);

-- Create PCards table.
CREATE TABLE IF NOT EXISTS pcards (
    -- The card table. (Default 200p card).
    id INT NOT NULL AUTO_INCREMENT,
    cNumber VARCHAR(20),
    isUsed BOOLEAN NOT NULL DEFAULT 0,
    worth INT NOT NULL DEFAULT 200,

    -- Keys.
    PRIMARY KEY (id)
);

-- Create OTP request table.
CREATE TABLE IF NOT EXISTS otpRequests (
    -- OTP Secure Request table.
    id INT NOT NULL AUTO_INCREMENT,
    requestId VARCHAR(32),
    query VARCHAR(8192),

    -- Keys.
    PRIMARY KEY (id),
    UNIQUE KEY (requestId)
);

-- Create the Telemetry table (AKA Fun Logs)
CREATE TABLE IF NOT EXISTS telemetry (
    -- Telemetry entry.
    id INT NOT NULL AUTO_INCREMENT,
    ip VARCHAR(128) NOT NULL,
    logdate DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    username VARCHAR(255) NOT NULL DEFAULT "Unknown Dumbass",
    telephone VARCHAR(8192) NOT NULL,

    -- ip - Orgin IP
    -- logDate - Date of entry
    -- username - Originating user ("Unknown Dumbass" if not set.)

    -- Keys.
    PRIMARY KEY (id)
);

-- Create the first telemetry entry.
INSERT INTO telemetry (
    ip, username, telephone
) VALUES (
    "127.0.0.1", "SystemDB", "Succesfully installed the base database."
);
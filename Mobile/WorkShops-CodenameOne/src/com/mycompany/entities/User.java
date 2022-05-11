/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package com.mycompany.entities;

import java.util.Date;

/**
 *
 * @author MSI
 */
public class User {

     private long id;
    private String nom;
    private String prenom;
    private Date dateNaissance;
    private String email;
    private String username;
    private String password;
    private int numTel;
    private String adresse;
    private String genre;
    private int IdEquipe;
    private String roles;

    public User() {
    }

    public User(long id, String nom, String prenom, Date dateNaissance, String email, String username, String password, int numTel, String adresse, String genre, int IdEquipe, String roles) {
        this.id = id;
        this.nom = nom;
        this.prenom = prenom;
        this.dateNaissance = dateNaissance;
        this.email = email;
        this.username = username;
        this.password = password;
        this.numTel = numTel;
        this.adresse = adresse;
        this.genre = genre;
        this.IdEquipe = IdEquipe;
        this.roles = roles;
    }
    //
     public User(String nom, String prenom, Date dateNaissance, String email, String username, String password, int numTel, String adresse, String roles) {
        this.nom = nom;
        this.prenom = prenom;
        this.dateNaissance = dateNaissance;
        this.email = email;
        this.username = username;
        this.password = password;
        this.numTel = numTel;
        this.adresse = adresse;
        this.roles = roles;
    }

    public User(String nom, String prenom, Date dateNaissance, String email, String username, String password, int numTel, String adresse, String genre, int IdEquipe, String roles) {
        this.nom = nom;
        this.prenom = prenom;
        this.dateNaissance = dateNaissance;
        this.email = email;
        this.username = username;
        this.password = password;
        this.numTel = numTel;
        this.adresse = adresse;
        this.genre = genre;
        this.IdEquipe = IdEquipe;
        this.roles = roles;
    }

    public long getId() {
        return id;
    }

    public void setId(long id) {
        this.id = id;
    }

    public String getNom() {
        return nom;
    }

    public void setNom(String nom) {
        this.nom = nom;
    }

    public String getPrenom() {
        return prenom;
    }

    public void setPrenom(String prenom) {
        this.prenom = prenom;
    }

    public Date getDateNaissance() {
        return dateNaissance;
    }

    public void setDateNaissance(Date dateNaissance) {
        this.dateNaissance = dateNaissance;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public String getUsername() {
        return username;
    }

    public void setUsername(String username) {
        this.username = username;
    }

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    public int getNumTel() {
        return numTel;
    }

    public void setNumTel(int numTel) {
        this.numTel = numTel;
    }

    public String getAdresse() {
        return adresse;
    }

    public void setAdresse(String adresse) {
        this.adresse = adresse;
    }

    public String getGenre() {
        return genre;
    }

    public void setGenre(String genre) {
        this.genre = genre;
    }

    public int getIdEquipe() {
        return IdEquipe;
    }

    public void setIdEquipe(int IdEquipe) {
        this.IdEquipe = IdEquipe;
    }

    public String getRoles() {
        return roles;
    }

    public void setRoles(String roles) {
        this.roles = roles;
    }

    

   

 

   

}

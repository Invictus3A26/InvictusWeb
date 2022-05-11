/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package com.mycompany.services;

import com.codename1.io.CharArrayReader;
import com.codename1.io.ConnectionRequest;
import com.codename1.io.JSONParser;
import com.codename1.io.MultipartRequest;
import com.codename1.io.NetworkEvent;
import com.codename1.io.NetworkManager;
import com.codename1.ui.Dialog;
import com.codename1.ui.TextField;
import com.codename1.ui.events.ActionListener;
import com.codename1.ui.util.Resources;
import com.mycompany.entities.SessionManager;
import com.mycompany.entities.User;
import com.mycompany.gui.NewsfeedForm;
import com.mycompany.gui.ProfileForm;
import com.mycompany.gui.back.NewsfeedFormBack;
import com.mycompany.gui.back.UserFormBack;
import com.mycompany.utils.Statics;
import java.io.IOException;
import java.io.Reader;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;
import java.util.Map;

/**
 *
 * @author MSI
 */
public class ServiceUser {

    public ArrayList<User> User;

    public static ServiceUser instance = null;
    public boolean resultOK;
    private ConnectionRequest req;
    String json;

    private ServiceUser() {
        req = new ConnectionRequest();
    }

    public static ServiceUser getInstance() {
        if (instance == null) {
            instance = new ServiceUser();
        }
        return instance;
    }

    public void signup(TextField nom, TextField prenom,TextField dateNaissance,TextField email,TextField username,TextField password,TextField numtel,TextField adresse, Resources res) {
        String url = Statics.BASE_URL + "/user/signup/mobile?email=" + email.getText().toString() + "&nom=" + nom.getText().toString() + "&prenom=" + prenom.getText().toString() + "&password=" + password.getText().toString() + "&numtel=" + numtel.getText().toString()+ "&dateNaissance=" + dateNaissance.getText().toString()+ "&username=" + username.getText().toString()+ "&adresse=" + adresse.getText().toString();
        req.setUrl(url);
        System.out.println(url);
        if (username.getText().equals(" ") && password.getText().equals(" ")) {
            Dialog.show("erreur", "veuillez remplir les champs", "ok", null);
        }
        req.addResponseListener((e) -> {
            byte[] data = (byte[]) e.getMetaData();
            String responseData = new String(data);
            System.out.println("data===>" + responseData);
        });
        NetworkManager.getInstance().addToQueueAndWait(req);

    }

    public void signin(TextField username, TextField password, Resources res) {
        String url = Statics.BASE_URL + "/user/login/mobile?username=" + username.getText().toString() + "&password=" + password.getText().toString();
        req.setUrl(url);
        System.out.println(url);

        req.addResponseListener((e) -> {
            JSONParser j = new JSONParser();
            String json = new String(req.getResponseData()) + "";
            try {
                if (json.equals("failed")) {
                    Dialog.show("echec d'authentification", "username or password incorrect", "OK", null);

                } else {
                    System.out.println("data ==" + json);
                    Map<String, Object> user = j.parseJSON(new CharArrayReader(json.toCharArray()));
                    java.util.List<String> role = (java.util.List<String>) user.get("roles");

                    //  Map<String, Object> role = j.parseJSON((Reader) user.get("roles"));
//String role=(user.get("roles").getJsonObject(0)) ;
                    //Float status = Float.parseFloat(user.get("status").toString());
                    System.out.println(role.get(0));
                  /*  if (status == 0) {
                        Dialog.show("error", "you are banned", "ok", null);
                    } else if (status == 2) {
                        Dialog.show("error", "wait until we approve your subscription by then you are simple user ", "ok", null);
                        new NewsfeedForm(res).show();
                    }
                    */
                    if (!user.isEmpty()  && "ROLE_ADMIN".equals(role.get(0))) {
                        new UserFormBack(res).show();// yemchi lel home yelzem nrigelha
                        SessionManager.setEmail(user.get("email").toString());
                        float id = Float.parseFloat(user.get("id").toString());
                        SessionManager.setId((int) id);
                        //      SessionManager.setId();// hedhi mochkla
                        SessionManager.setNom(user.get("nom").toString());
                        SessionManager.setPrenom(user.get("prenom").toString());
                        SessionManager.setPassword(user.get("password").toString());
                    }
                    if (!user.isEmpty()  && "ROLE_USER".equals(role.get(0))) {
                        new ProfileForm(res).show();// yemchi lel home yelzem nrigelha
                        SessionManager.setEmail(user.get("email").toString());
                        float id = Float.parseFloat(user.get("id").toString());
                        SessionManager.setId((int) id);
                        //      SessionManager.setId();// hedhi mochkla
                        SessionManager.setNom(user.get("nom").toString());
                        SessionManager.setPrenom(user.get("prenom").toString());
                        SessionManager.setPassword(user.get("password").toString());
                    }
                }
            } catch (Exception ex) {
                ex.printStackTrace();
            }
        });

        NetworkManager.getInstance().addToQueueAndWait(req);

    }

   public String getPasswordbyPhone(String phoneNumber, Resources res) {
        String url = Statics.BASE_URL + "user/passwordMobile?phoneNumber=" + phoneNumber;
        req.setUrl(url);
        System.out.println(url);

        req.addResponseListener((e) -> {
            JSONParser j = new JSONParser();
            json = new String(req.getResponseData()) + "";
            try {

                System.out.println("data ==" + json);
                Map<String, Object> password = j.parseJSON(new CharArrayReader(json.toCharArray()));

            } catch (Exception ex) {
                ex.printStackTrace();
            }
        });

        NetworkManager.getInstance().addToQueueAndWait(req);
        return json;
    }
    
/*
    public static void EditUser(String nom, String prenom, String email, String password, String imageFile) {
        String url = Statics.BASE_URL + "/user/editUserMobile?&email=" + email + "&password=" + password + "&nom=" + nom + "&prenom=" + prenom + "&imageFile=" + imageFile;
        MultipartRequest req = new MultipartRequest();
        req.setUrl(url);
        req.setPost(true);
        req.addArgument("nom", nom);
        req.addArgument("prenom", prenom);
        req.addArgument("password", password);
        req.addArgument("email", email);
        req.addResponseListener((response) -> {
            byte[] data = (byte[]) response.getMetaData();
            String a = new String(data);
            System.out.println(a);
            if (a.equals("success")) {
            } else {
                // Dialog.show("erreur", "echec de modification", "OK", null);
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req);

    }
    
   */
    
public ArrayList<User> parseUser(String jsonText){
        try {
            User=new ArrayList<>();
            JSONParser j = new JSONParser();// Instanciation d'un objet JSONParser permettant le parsing du résultat json

            /*
                On doit convertir notre réponse texte en CharArray à fin de
            permettre au JSONParser de la lire et la manipuler d'ou vient 
            l'utilité de new CharArrayReader(json.toCharArray())
            
            La méthode parse json retourne une MAP<String,Object> ou String est 
            la clé principale de notre résultat.
            Dans notre cas la clé principale n'est pas définie cela ne veux pas
            dire qu'elle est manquante mais plutôt gardée à la valeur par defaut
            qui est root.
            En fait c'est la clé de l'objet qui englobe la totalité des objets 
                    c'est la clé définissant le tableau de tâches.
            */
            Map<String,Object> UserListJson = j.parseJSON(new CharArrayReader(jsonText.toCharArray()));
            
              /* Ici on récupère l'objet contenant notre liste dans une liste 
            d'objets json List<MAP<String,Object>> ou chaque Map est une tâche.               
            
            Le format Json impose que l'objet soit définit sous forme
            de clé valeur avec la valeur elle même peut être un objet Json.
            Pour cela on utilise la structure Map comme elle est la structure la
            plus adéquate en Java pour stocker des couples Key/Value.
            
            Pour le cas d'un tableau (Json Array) contenant plusieurs objets
            sa valeur est une liste d'objets Json, donc une liste de Map
            */
            List<Map<String,Object>> list = (List<Map<String,Object>>)UserListJson.get("root");
            //Parcourir la liste des tâches Json

            for(Map<String,Object> obj : list){
                    java.util.List<String> role = (java.util.List<String>) obj.get("roles");

                //Création des tâches et récupération de leurs données
                User t = new User();
                float id = Float.parseFloat(obj.get("id").toString());
                t.setId((int)id);
               
                t.setEmail(obj.get("email").toString());
                t.setNom(obj.get("nom").toString());
                t.setPrenom(obj.get("prenom").toString());
//t.setRoles(role.get(0));
                
               
                
               
                        
                //Ajouter la tâche extraite de la réponse Json à la liste
                User.add(t);
            }
            
            
        } catch (IOException ex) {
            
        }
         /*
            A ce niveau on a pu récupérer une liste des tâches à partir
        de la base de données à travers un service web
        
        */
        return User;
    }


   public ArrayList<User> getAllUser(){
        ArrayList<User> listUser = new ArrayList<>();

        String url = Statics.BASE_URL+"/user/all/users";
        req.setUrl(url);
        req.setPost(false);
        req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                User = parseUser(new String(req.getResponseData()));
                req.removeResponseListener(this);
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req);
        return User;
    }
   
    //////////activer//////////
    public boolean BanUser(float id) {

        String url = Statics.BASE_URL + "/ban?id="+id;
        req.setUrl(url);
        req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                resultOK = req.getResponseCode() == 200;
                req.removeResponseListener(this);
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req);
        return resultOK;
    }
    //////////activer//////////
    public boolean UnBanUser(float id) {

        String url = Statics.BASE_URL + "/unban?id="+id;
        req.setUrl(url);
        req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                resultOK = req.getResponseCode() == 200;
                req.removeResponseListener(this);
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req);
        return resultOK;
    }



}

package com.kykj.haru2;

import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.net.Uri;
import android.os.Bundle;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.fragment.app.FragmentTransaction;
import androidx.room.Room;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.ImageView;
import android.widget.TextView;

import java.io.InputStream;
import java.net.URI;
import java.io.*;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.List;

import static java.io.FileDescriptor.in;

public class MainActivity extends AppCompatActivity {
    private AppDatabase db;
    private TextView test, test2;
    private ImageView img1, img2, img3;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        final Toolbar toolbar = findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);
       toolbar.setBackgroundColor(getResources().getColor(R.color.Actionbar));
       toolbar.setTitleTextColor(getResources().getColor(R.color.Actionbar));
        test = (TextView)findViewById(R.id.setdata);
        test2 = (TextView)findViewById(R.id.setdata2);

        img1 = (ImageView)findViewById(R.id.img1);
        img2 = (ImageView)findViewById(R.id.img2);
        img3 = (ImageView)findViewById(R.id.img3);

        db = Room.databaseBuilder(this,AppDatabase.class, "todo-db").allowMainThreadQueries().build();
        try {
            fetch();
        } catch (Exception e) {
            e.printStackTrace();
        }

    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_main, menu);
        return true;

    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();
        //noinspection SimplifiableIfStatement
        if (id == R.id.action_settings) {

            return true;
        }else if(id == R.id.add_plus){
            Bundle savedInstanceState;
            savedInstanceState = new Bundle();
            Date now = new Date();
            SimpleDateFormat realYear = new SimpleDateFormat("yyyy.MM.dd");
            String years = realYear.format(now);
            savedInstanceState.putString("formFrag1",years);
            FragmentTransaction transaction = getSupportFragmentManager().beginTransaction();
            ForFragment forFragment = new ForFragment();
            forFragment.setArguments(savedInstanceState);
            transaction.commit();
            Intent intent = new Intent(this, NoteAdd.class);
            startActivity(intent);
        }

        return super.onOptionsItemSelected(item);
    }
    private void fetch(){
        Uri uri1;
        Uri uri2;
        Uri uri3;
        List<Todo> list = (List<Todo>) db.todoDao().getAll();
        String list_one = "목록";
        for(Todo todo : list){

            uri1 = Uri.parse(todo.getImgname1());
            System.out.println(uri1);
            img1.setImageURI(uri1);

            list_one += "\n"+todo.getId() +", " + todo.getYear() +", "+ todo.getWeather() +", " + todo.getContent() +", " + todo.getStar_one() +", " + todo.getStar_two()+", "  + todo.getStar_three()+", " +todo.getImgname1()+", " +todo.getImgname2()+", " +todo.getImgname3();
        }
        System.out.println(list_one);
        test.setText(list_one);
    }
}

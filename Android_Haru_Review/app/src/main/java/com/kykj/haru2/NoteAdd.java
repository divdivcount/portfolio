package com.kykj.haru2;

import android.app.FragmentTransaction;
import android.content.Intent;
import android.os.Build;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;

import androidx.annotation.RequiresApi;
import androidx.appcompat.app.ActionBar;
import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentManager;
import androidx.fragment.app.FragmentPagerAdapter;
import androidx.room.Room;
import androidx.viewpager.widget.ViewPager;

import org.greenrobot.eventbus.EventBus;

import java.text.SimpleDateFormat;
import java.util.Date;

import me.relex.circleindicator.CircleIndicator;


public class NoteAdd extends AppCompatActivity {

    FragmentPagerAdapter adapterViewPager;

    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.noteadd);
        AppDatabase db = Room.databaseBuilder(this, AppDatabase.class, "todo-db").build();
        ActionBar actionBar = getSupportActionBar();
        getSupportActionBar().setElevation(0);


        ViewPager vpPager = (ViewPager) findViewById(R.id.vpPager);
        adapterViewPager = new MyPagerAdapter(getSupportFragmentManager());
        vpPager.setAdapter(adapterViewPager);

//        CircleIndicator indicator = (CircleIndicator) findViewById(R.id.indicator);
//        indicator.setViewPager(vpPager);
        vpPager.setOffscreenPageLimit(4);
    }

    public static class MyPagerAdapter extends FragmentPagerAdapter {
        private static int NUM_ITEMS = 4;

        public MyPagerAdapter(FragmentManager fragmentManager) {
            super(fragmentManager);
        }

        // Returns total number of pages
        @Override
        public int getCount() {
            return NUM_ITEMS;
        }

        // Returns the fragment to display for that page
        @RequiresApi(api = Build.VERSION_CODES.O)
        @Override
        public Fragment getItem(int position) {
            switch (position) {
                case 0:
                    Date now = new Date();
                    SimpleDateFormat realYear = new SimpleDateFormat("yyyy.MM.dd");
                    String years = realYear.format(now);
                    return FirstFragment.newInstance(0, years);
                case 1:
                    return SecondFragment.newInstance(1, "Page # 2");
                case 2:
                    return ThirdFragment.newInstance(2, "Page # 3");
                case 3:
                    return ForFragment.newInstance("3", "Page # 4");
                default:
                    return null;
            }
        }

        // Returns the page title for the top indicator
        @Override
        public CharSequence getPageTitle(int position) {
            return "Page " + position;
        }

    }
    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.submenu, menu);
        return true;
    }
    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();
        //noinspection SimplifiableIfStatement
        if (id == R.id.w_close) {
            Intent intent = new Intent(this, MainActivity.class);
            startActivity(intent);
            return true;
        }else{

        }

        return super.onOptionsItemSelected(item);
    }

}
